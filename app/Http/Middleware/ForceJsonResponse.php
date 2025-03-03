<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Return error message if the request is not expecting JSON
        if (!$request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'API access only. Please use an API client.'
            ], 403);
        }

        return $next($request);
    }
}
