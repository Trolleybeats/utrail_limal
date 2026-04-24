<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->hasEnabledTwoFactorAuthentication()) {
            if (! $request->routeIs('two-factor.*', 'security.edit', 'user-password.update', 'logout')) {
                return redirect()->route('security.edit')->with('warning', 'Veuillez activer l\'authentification à deux facteurs pour accéder à l\'administration.');
            }
        }

        return $next($request);
    }
}
