<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class MagicLinkController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.magic-link');
    }

    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Validasi keaktifan akun dan peran (Hanya untuk peran 'industri')
        if ($user->status !== 'aktif') {
            return back()->withErrors([
                'email' => 'Akun industri Anda sedang tidak aktif.',
            ]);
        }

        if (!$user->hasRole('industri')) {
            return back()->withErrors([
                'email' => 'Email ini bukan merupakan email pembimbing industri.',
            ]);
        }

        // Membuat signed URL yang kedaluwarsa dalam 7 hari
        $magicLink = URL::temporarySignedRoute(
            'magic.login',
            now()->addDays(7),
            ['user' => $user->id]
        );

        // Di lingkup production, link ini dikirimkan via Email / WhatsApp API.
        // Di lingkup local development ini, kita flash link ke session agar bisa langsung diklik untuk simulasi.
        return back()->with([
            'status' => 'Magic Link login berhasil dibuat!',
            'magicLink' => $magicLink,
        ]);
    }

    public function loginWithMagicLink(Request $request, $userId)
    {
        // Memeriksa keabsahan tandatangan dan waktu kedaluwarsa signed URL
        if (!$request->hasValidSignature()) {
            abort(401, 'Link masuk (Magic Link) tidak valid atau telah kedaluwarsa.');
        }

        $user = User::findOrFail($userId);

        if ($user->status !== 'aktif') {
            return redirect('/login')->withErrors([
                'login' => 'Akun Anda sedang dinonaktifkan.',
            ]);
        }

        // Autentikasi otomatis
        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/industri/dashboard');
    }
}
