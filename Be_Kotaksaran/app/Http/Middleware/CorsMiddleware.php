<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Ganti dengan domain atau port yang benar
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
            $response->headers->set('Content-Length', 0);
        }
        return $response;
    }
}
