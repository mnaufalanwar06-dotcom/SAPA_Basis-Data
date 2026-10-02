<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan formulir login admin.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }
            Auth::logout();
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $remember = $request->boolean('remember');

        // Coba autentikasi via Auth::attempt
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            // Verifikasi apakah pengguna memiliki role admin
            if (!$user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'Akses ditolak: Akun Anda tidak memiliki hak akses sebagai Administrator.',
                    ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
            ]);
    }

    /**
     * Keluar dari sesi admin (Logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
