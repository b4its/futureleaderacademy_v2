<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginControllers extends Controller
{
    /**
     * Display auth page.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('pembelajaran.index');
        }

        return view('accounts.auth');
    }

    /**
     * Handle login attempt.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string',
            'role_target' => 'required|in:panel,learning',
        ]);

        // Rate limiting: max 5 attempts per minute
        $throttleKey = 'login_' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            // Redirect berdasarkan role_target
            if ($request->role_target === 'panel') {
                // Hanya admin dan pengajar yang bisa akses panel
                if (in_array($user->role, ['admin', 'pengajar'])) {
                    return redirect()->intended('/admin');
                }

                Auth::logout();
                $request->session()->invalidate();

                throw ValidationException::withMessages([
                    'email' => 'Anda tidak memiliki akses ke Sistem Panel.',
                ]);
            }

            // Redirect ke pembelajaran untuk member
            return redirect()->intended(route('pembelajaran.index'));
        }

        RateLimiter::hit($throttleKey, 60);

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
