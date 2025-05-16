<?php

namespace Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Config;
use PDO;

class TokenService
{
    private static $algorithm = 'HS256';
    private static $refreshTokenExpiry = 604800; // 7 days

    public static function issueTokens($pdo, $userId, $otherInfo = null)
    {
        $issuedAt = time();

        // Fetch current token version from database
        $stmt = $pdo->prepare("SELECT token_version FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $tokenVersion = $result ? $result['token_version'] : 0;

        // Generate Access Token
        $accessTokenPayload = [
            'sub' => $userId,
            'iat' => $issuedAt,
            'exp' => $issuedAt + Config::getJwtExpiration(),
            'other_info' => $otherInfo,
            'token_version' => $tokenVersion, // Include token version
        ];
        $accessToken = JWT::encode($accessTokenPayload, Config::getJwtSecret(), self::$algorithm);

        // Generate Refresh Token
        $refreshTokenPayload = [
            'sub' => $userId,
            'iat' => $issuedAt,
            'exp' => $issuedAt + self::$refreshTokenExpiry,
            'token_version' => $tokenVersion, // Include token version
        ];
        $refreshToken = JWT::encode($refreshTokenPayload, Config::getJwtSecret(), self::$algorithm);

        return ['access_token' => $accessToken, 'refresh_token' => $refreshToken];
    }

    public static function refreshAccessToken($pdo, $refreshToken)
    {
        try {
            $payload = JWT::decode($refreshToken, new Key(Config::getJwtSecret(), self::$algorithm));

            // Get stored token version from database
            $stmt = $pdo->prepare("SELECT token_version FROM users WHERE id = ?");
            $stmt->execute([$payload->sub]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedTokenVersion = $result ? $result['token_version'] : null;

            // Ensure refresh token matches latest token version
            if ($storedTokenVersion === null || $storedTokenVersion !== $payload->token_version) {
                return ['error' => 'Invalid refresh token'];
            }

            // Generate new access token
            return self::issueTokens($pdo, $payload->sub);
        } catch (\Exception $e) {
            return ['error' => 'Invalid refresh token'];
        }
    }
}
