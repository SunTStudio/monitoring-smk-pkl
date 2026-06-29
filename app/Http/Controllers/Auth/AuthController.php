<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentialsInput = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah input login berupa email atau username
        $fieldType = filter_var($credentialsInput['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $credentialsInput['login'],
            'password' => $credentialsInput['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek status keaktifan user
            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun Anda sedang dinonaktifkan atau ditangguhkan.',
                ]);
            }

            $request->session()->regenerate();

            // Redirect berdasarkan peran (roles Spatie)
            if ($user->hasRole('admin') || $user->hasRole('koordinator')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('pembimbing')) {
                return redirect()->intended('/pembimbing/dashboard');
            } elseif ($user->hasRole('industri')) {
                return redirect()->intended('/industri/dashboard');
            } elseif ($user->hasRole('siswa')) {
                return redirect()->intended('/siswa/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau Password yang dimasukkan salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
