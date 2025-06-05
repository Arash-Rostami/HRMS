<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LiteSpeedCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $nonCachedRoutes = [
            'user.panel.edit',
            'user.panel.music',
            'user.panel.dms',
            'user.panel.delegation',
            'user.panel.onboarding',
            'user.panel.suggestion',
            'user.panel.analytics',
            'user.presence'
        ];

        if (!in_array($request->route()->getName(), $nonCachedRoutes)) {
            $response->headers->set('X-LiteSpeed-Cache-Control', 'public,max-age=360');
        } else {
            $response->headers->set('X-LiteSpeed-Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        return $response;
    }
}
