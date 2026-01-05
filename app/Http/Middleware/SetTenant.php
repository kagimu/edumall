<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->school) {
            tenancy()->initialize(auth()->user()->school);
        }
        return $next($request);
    }
}