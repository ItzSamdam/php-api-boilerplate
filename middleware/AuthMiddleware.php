<?php

namespace Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Utils\Request;
use Utils\Response;
use Config\Config;

class AuthMiddleware
{

    public function handle(Request $request)
    {
        $authHeader = $request->getAuthorizationHeader();

        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Response::unauthorized('No token provided');
            return;
        }

        $token = $matches[1];

        try {
            // Decode and verify the JWT token
            $payload = JWT::decode($token, new Key(Config::getJwtSecret(), 'HS256'));

            if (!$payload || !isset($payload->exp) || $payload->exp < time()) {
                Response::unauthorized('Token has expired');
                return;
            }

            // Store user ID in request for controllers to use
            $_REQUEST['userId'] = $payload->sub;
        } catch (\Exception $e) {
            Response::unauthorized('Invalid token');
        }
    }
}
