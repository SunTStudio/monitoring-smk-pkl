<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Custom 403 — Robot Guard
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, Request $request) {
            if (!$request->is('api/*')) {
                return response()->view('errors.403', [], 403);
            }
        });

        // Custom 403 — Authorization
        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {
            if (!$request->is('api/*')) {
                return response()->view('errors.403', [], 403);
            }
        });

        // All HTTP exceptions: route to custom pages or generic fallback
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return null; // let the default handler deal with API requests
            }

            $code = $e->getStatusCode();
            $view = "errors.{$code}";

            // Check if a specific custom view exists for this code
            if (\Illuminate\Support\Facades\View::exists($view)) {
                return response()->view($view, [], $code);
            }

            // Fallback: generic ghost page for any other error
            return response()->view('errors.generic', [
                'code' => $code,
                'message' => $e->getMessage() ?: null,
            ], $code);
        });
    })->create();
