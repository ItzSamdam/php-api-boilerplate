<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

namespace Config;

// Load Composer's autoloader (needed for phpdotenv)
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Config
{
    private static $env;

    /**
     * Load environment variables from .env file
     * and validate required keys.
     */
    public static function loadEnv()
    {
        if (!self::$env) {
            $envPath = __DIR__ . '/../.env';
            if (!file_exists($envPath)) {
                self::logError('Environment file not found.');
                throw new \Exception('Environment file not found.');
            }

            // Load .env variables into $_ENV
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            self::$env = $_ENV;

            // Validate critical variables
            self::validateRequired([
                'DB_HOST',
                'DB_NAME',
                'DB_USER',
                'DB_PASS',
                'JWT_SECRET'
                // add more required keys as needed
            ]);
        }
    }

    /**
     * Ensure required environment variables are present.
     * Throws exception if missing in production.
     */
    private static function validateRequired(array $requiredKeys)
    {
        $envMode = self::$env['APP_ENV'] ?? 'development';

        foreach ($requiredKeys as $key) {
            if (empty(self::$env[$key])) {
                $message = "Missing required environment variable: {$key}";

                // Log error for visibility
                self::logError($message);

                // Fail fast in production
                if ($envMode === 'production') {
                    throw new \Exception($message);
                }
            }
        }
    }

    /**
     * Log configuration errors to a file.
     */
    private static function logError(string $message)
    {
        $logPath = self::$env['LOG_PATH'] ?? __DIR__ . '/logs';
        if (!is_dir($logPath)) {
            mkdir($logPath, 0777, true);
        }

        $file = $logPath . '/config_errors.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($file, "[{$timestamp}] {$message}\n", FILE_APPEND);
    }

    // -------------------------
    // Database configuration
    // -------------------------
    public static function getDbHost()
    {
        return self::$env['DB_HOST'] ?? 'localhost';
    }
    public static function getDbName()
    {
        return self::$env['DB_NAME'] ?? 'api_db';
    }
    public static function getDbUser()
    {
        return self::$env['DB_USER'] ?? 'root';
    }
    public static function getDbPass()
    {
        return self::$env['DB_PASS'] ?? '';
    }

    // -------------------------
    // API configuration
    // -------------------------
    public static function getApiVersion()
    {
        return self::$env['API_VERSION'] ?? '1.0.0';
    }
    public static function getApiBasePath()
    {
        return self::$env['API_BASE_PATH'] ?? '/api/v1';
    }

    // -------------------------
    // JWT configuration
    // -------------------------
    public static function getJwtSecret()
    {
        return self::$env['JWT_SECRET'] ?? 'your-secret-key';
    }
    public static function getJwtExpiration()
    {
        return (int)(self::$env['JWT_EXPIRATION'] ?? 3600);
    }

    // -------------------------
    // Logging configuration
    // -------------------------
    public static function getLogPath()
    {
        return self::$env['LOG_PATH'] ?? __DIR__ . '/logs';
    }
    public static function getLogLevel()
    {
        return self::$env['LOG_LEVEL'] ?? 'debug';
    }

    // -------------------------
    // Mailer configuration
    // -------------------------
    public static function getSmtpServer()
    {
        return self::$env['SMTP_SERVER'] ?? 'smtp.example.com';
    }
    public static function getSmtpPort()
    {
        return (int)(self::$env['SMTP_PORT'] ?? 587);
    }
    public static function getSmtpUsername()
    {
        return self::$env['SMTP_USERNAME'] ?? null;
    }
    public static function getSmtpPassword()
    {
        return self::$env['SMTP_PASSWORD'] ?? null;
    }
    public static function getSmtpFromAddress()
    {
        return self::$env['SMTP_FROM_ADDRESS'] ?? null;
    }
    public static function getSmtpFromName()
    {
        return self::$env['SMTP_FROM_NAME'] ?? 'Default Sender';
    }

    // -------------------------
    // Cloudinary configuration
    // -------------------------
    public static function getCloudName()
    {
        return self::$env['CLOUD_NAME'] ?? null;
    }
    public static function getCloudApiKey()
    {
        return self::$env['CLOUD_API_KEY'] ?? null;
    }
    public static function getCloudApiSecret()
    {
        return self::$env['CLOUD_API_SECRET'] ?? null;
    }
}

// Load environment variables immediately
Config::loadEnv();
