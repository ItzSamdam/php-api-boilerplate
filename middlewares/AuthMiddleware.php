/**
* middleware/AuthMiddleware.php - Authentication middleware
*/
<?php

namespace Api\Middleware;

use Api\Utils\Request;
use Api\Utils\Response;
use Api\Config\Config;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        $authHeader = $request->getAuthorizationHeader();

        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Response::unauthorized('No token provided');
        }

        $token = $matches[1];

        // Verify JWT token (simplified example)
        try {
            // In a real application, you would use a proper JWT library
            $tokenParts = explode('.', $token);

            if (count($tokenParts) !== 3) {
                Response::unauthorized('Invalid token format');
            }

            $payload = json_decode(base64_decode($tokenParts[1]), true);

            if (!$payload || !isset($payload['exp']) || $payload['exp'] < time()) {
                Response::unauthorized('Token has expired');
            }

            // Store user ID in request for controllers to use
            // In a real application, you would properly verify the signature
            $_REQUEST['userId'] = $payload['sub'];
        } catch (\Exception $e) {
            Response::unauthorized('Invalid token');
        }
    }
}
