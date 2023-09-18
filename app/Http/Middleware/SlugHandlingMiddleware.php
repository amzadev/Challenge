<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SlugHandlingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $parts = explode('/', $path);

        // Check if the URL contains a slug and matches the desired format
        if (count($parts) === 2 && preg_match('/^[a-zA-Z0-9-]+$/', $parts[1])) {
            // Handle routes with slugs differently (e.g., call a specific controller)
            return app()->call('App\Http\Controllers\RedirectController@index', $parts[1]);
        }

        return $next($request);
    }
}
