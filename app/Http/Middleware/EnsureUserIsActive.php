<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * If the authenticated user has been deactivated, the session is
     * destroyed immediately so the account cannot continue to use
     * administrative or non-administrative pages.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if ($user === null || $user->isActive()) {
            return $next($request);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            abort(403, 'Your account has been deactivated.');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Your account has been deactivated. Contact an administrator.',
        ]);
    }
}
