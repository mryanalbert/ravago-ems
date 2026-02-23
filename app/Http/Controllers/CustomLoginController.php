<?php

namespace App\Http\Controllers;

use App\Models\DbUserUsr;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class CustomLoginController extends Controller
{
    public function index()
    {
        if (Auth::check() || Filament::auth()->check()) {
            return redirect(Filament::getPanel('admin')->getUrl());
        }

        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Unique key per IP/device
        $key = 'login-attempt:' . $request->ip();

        $maxAttempts = 3;       // Maximum allowed failed attempts
        $lockoutSeconds = 60;   // Lockout duration after max attempts

        // 1️⃣ Check if the device is locked out
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            $timeMessage = $seconds < 60
                ? $seconds . ' second' . ($seconds === 1 ? '' : 's')
                : ceil($seconds / 60) . ' minute' . (ceil($seconds / 60) === 1 ? '' : 's')
                . " ($seconds seconds)";

            return redirect('/login')->withErrors([
                'error' => "Too many login attempts. Please wait $timeMessage",
            ]);
        }

        // 2️⃣ Attempt login
        $user = DbUserUsr::where('email', $request->email)
            ->where('isActive', 1)             // column in DbUserUsr
            ->whereHas('roles')                // only checks if the user has at least one role
            ->first();

        if ($user && Hash::check($request->password, $user->userPassword)) {
            // SUCCESS: Clear the strikes
            RateLimiter::clear($key);

            $request->session()->regenerate();

            Filament::auth()->login($user);

            return redirect(Filament::getPanel('admin')->getUrl());
        }

        // 3️⃣ FAIL: Register a strike
        // The decay is now set to lockoutSeconds so the first hit won't expire before the lockout
        RateLimiter::hit($key, $lockoutSeconds);

        $remaining = RateLimiter::remaining($key, $maxAttempts);

        // Only show remaining attempts if greater than 0
        $message = $remaining != 0
            ? "Attempts remaining: $remaining"
            : "You have reached the maximum login attempts. Please wait for 1 minute.";

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records. ' . $message,
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        // Use the same key format as your authenticate() method
        $key = 'login-attempt:' . request()->ip();

        // 1. Check if the device is currently locked out
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            // $minutes = ceil($seconds / 60);

            if ($seconds < 60) {
                $timeMessage = $seconds . ' second' . ($seconds === 1 ? '' : 's');
            } else {
                $minutes = ceil($seconds / 60);
                $timeMessage = $minutes . ' minute' . ($minutes === 1 ? '' : 's') . " ($seconds seconds)";
            }

            return redirect('/login')->withErrors([
                'error' => "Too many login attempts. Please wait $timeMessage",
            ]);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
            $user = DbUserUsr::where('email', $googleUser->getEmail())
                ->where('isActive', 1)             // column in DbUserUsr
                ->whereHas('roles')                // only checks if the user has at least one role
                ->first();

            if (!$user) {
                // Optional: Register a "hit" if they try to login with an unauthorized Google account
                // This prevents spammers from trying 100 different Google accounts.
                RateLimiter::hit($key, 120);

                return redirect('/login')->withErrors([
                    'error' => 'No account associated with this Google email. Attempts remaining: ' . RateLimiter::remaining($key, 3)
                ]);
            }

            // SUCCESS: Clear the strikes
            RateLimiter::clear($key);

            Auth::login($user);
            request()->session()->regenerate();
            Filament::auth()->login($user);

            return redirect(Filament::getPanel('admin')->getUrl());
        } catch (\Exception $e) {
            Log::error('Google login failed: ' . $e->getMessage());

            return redirect('/login')->withErrors([
                'error' => 'Failed to authenticate with Google.'
            ]);
        }
    }
}
