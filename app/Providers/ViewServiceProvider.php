<?php

namespace App\Providers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * BUG-15 fix: Pindahkan query notifikasi dari blade layout ke ViewComposer
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $unreadNotifications = Notifikasi::where('id_pengguna_tujuan_fk', Auth::id())
                    ->where('status_dibaca', false)
                    ->orderBy('tgl_notifikasi', 'desc')
                    ->get();

                $allNotifications = Notifikasi::where('id_pengguna_tujuan_fk', Auth::id())
                    ->orderBy('tgl_notifikasi', 'desc')
                    ->limit(5)
                    ->get();

                $view->with(compact('unreadNotifications', 'allNotifications'));
            } else {
                $view->with([
                    'unreadNotifications' => collect(),
                    'allNotifications' => collect(),
                ]);
            }
        });
    }
}
