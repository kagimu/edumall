<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->accountType === 'institution') {
            if (!$user->school_id) {
                return response()->json(['message' => 'School not configured for this user.'], 403);
            }

            // Set tenant context in session or config
            session(['tenant_school_id' => $user->school_id]);
        }

        return $next($request);
    }
}
