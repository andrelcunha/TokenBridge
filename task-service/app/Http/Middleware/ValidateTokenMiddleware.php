<?php

namespace App\Http\Middleware;

use Closure;
use Shared\TokenValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Shared\DTO\UserDTO;

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

        $userDTO = UserDTO::fromJson($decoded->userJson);

        $request->attributes->add(['user' => $userDTO]);
        return $next($request);
    }
}
