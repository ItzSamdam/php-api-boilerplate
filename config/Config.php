<?php

namespace Config;

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Config
{
    private static $env;

    public static function loadEnv()
    {
        if (!self::$env) {
            // Load environment variables from .env file
            $envPath = __DIR__ . '/../.env';
            if (!file_exists($envPath)) {
                throw new \Exception('Environment file not found.');
            }
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            self::$env = $_ENV;
        }
    }

    // Database configuration
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

    // API configuration
    public static function getApiVersion()
    {
        return self::$env['API_VERSION'] ?? '1.0.0';
    }
    public static function getApiBasePath()
    {
        return self::$env['API_BASE_PATH'] ?? '/api/v1';
    }

    // JWT configuration
    public static function getJwtSecret()
    {
        return self::$env['JWT_SECRET'] ?? 'your-secret-key';
    }
    public static function getJwtExpiration()
    {
        return self::$env['JWT_EXPIRATION'] ?? 3600;
    }

    // Logging configuration
    public static function getLogPath()
    {
        return self::$env['LOG_PATH'] ?? __DIR__ . '/logs';
    }
    public static function getLogLevel()
    {
        return self::$env['LOG_LEVEL'] ?? 'debug';
    }

    // mailer configuration
    public static function getSmtpServer()
    {
        return self::$env['SMTP_SERVER'] ?? 'smtp.example.com';
    }

    public static function getSmtpPort()
    {
        return self::$env['SMTP_PORT'] ?? 587;
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

    // cloudinary configuration
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

// Load environment variables
Config::loadEnv();
