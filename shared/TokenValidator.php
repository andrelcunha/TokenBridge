<?php
namespace Shared;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenValidator
{
    public static function validate($token)
    {
        try {
            $key = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}