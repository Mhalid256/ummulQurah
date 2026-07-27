<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLastLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->wasRecentlyCreated === false) {
            // Lightweight touch; avoided on every request in production via session flag.
            if (! $request->session()->get('last_login_touched')) {
                $request->user()->forceFill(['last_login_at' => now()])->saveQuietly();
                $request->session()->put('last_login_touched', true);
            }
        }

        return $next($request);
    }
}
