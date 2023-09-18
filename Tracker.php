<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class Tracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->fullUrl();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Check if the visitor is unique based on IP address and user agent
        $existingVisitor = DB::table('visitors')
            ->where('url', $url)
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->first();

        if (!$existingVisitor) {
            DB::table('visitors')->insert([
                'url' => $url,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
        }

        return $next($request);
    }
}
