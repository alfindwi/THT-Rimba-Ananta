<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class UserLogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle( $request, Closure $next)
    {
        $log = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'payload' => $request->all(),
        ];

        Log::info('User Request Log:', $log);

        return $next($request);
    }
}
