<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireActingOrganization
{
    /**
     * Super Administrators have no organization_id of their own. Before they
     * can create/edit organization-scoped records (donors, campaigns, etc.)
     * they need to pick which organization they're acting as, via the
     * "Acting as" switcher in the navbar. This stops the raw "organization_id
     * cannot be null" SQL error with a friendly redirect instead.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $isWriteAction = in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
        $isExemptRoute = $request->routeIs('admin.switch-organization')
            || $request->routeIs('admin.staff.*')
            || $request->routeIs('admin.roles.*')
            || $request->routeIs('admin.settings.*')
            || $request->routeIs('two-factor.*')
            || $request->routeIs('admin.two-factor.*')
            || $request->routeIs('logout');

        if ($user && $user->isSuperAdmin() && $isWriteAction && ! $isExemptRoute && ! session('acting_organization_id')) {
            return back()->with('error', 'Please pick an organization from the "Acting as" switcher at the top of the page before creating or editing records.');
        }

        return $next($request);
    }
}