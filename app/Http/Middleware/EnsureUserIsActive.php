<?php

namespace App\Http\Middleware;

use App\Models\DbUserUsr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get a fresh instance from the DB to bypass session caching
        $userAuth = Auth::user()?->fresh();

        if (! $userAuth) {
            return redirect()->route('login');
        }

        $user = DbUserUsr::find($userAuth->userId);

        // 2. Check if user is active
        if (! $user->isActive) {
            return $this->terminateSession($request, 'Your account is deactivated.');
        }

        // 3. Check if user has at least one active role
        $hasActiveRole = $user->roles()->exists();


        if (! $hasActiveRole) {
            return $this->terminateSession($request, 'You have no active role assigned.');
        }

        return $next($request);
    }

    /**
     * Forcefully kill the request and logout
     */
    protected function terminateSession(Request $request, string $message)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // If this is a Filament Save/Create request (AJAX/Livewire)
        // we MUST abort to prevent the DB transaction from completing.
        if ($request->header('X-Livewire') || $request->ajax()) {
            abort(403, $message);
        }

        return redirect()->route('login')->with('error', $message);
    }
}
