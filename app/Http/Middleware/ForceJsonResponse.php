<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        // Force the request to expect JSON
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        // Force the response content-type to be JSON too (optional)
        if (method_exists($response, 'header')) {
            $response->header('Content-Type', 'application/json');
        }

        return $response;
    }
}
