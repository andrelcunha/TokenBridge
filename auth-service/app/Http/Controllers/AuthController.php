<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $jwt = AuthController::generate($user);
        return response()->json(['token' => $jwt]);
    }

    private static function generate($user)
    {
        $payload = [
            'iss' => "auth-service", // Issuer
            'sub' => $user->id,      // Subject (user ID)
            'email' => $user->email,
            'role' => $user->role,
            'iat' => time(),         // Issued at
            'exp' => time() + env('JWT_EXPIRATION'), // Expiration
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return $jwt;
    }
    
}
