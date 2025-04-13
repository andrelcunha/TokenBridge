<?php

namespace App\Http\Middleware;

use Closure;
use Shared\TokenValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $decoded = TokenValidator::validate($token);

        if (!$decoded) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $request->attributes->add(['user' => $decoded]);
        return $next($request);
    }
}
