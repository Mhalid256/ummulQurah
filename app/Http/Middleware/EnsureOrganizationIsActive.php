<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->organization && $user->organization->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your organization account has been suspended. Please contact the platform administrator.',
            ]);
        }

        return $next($request);
    }
}
