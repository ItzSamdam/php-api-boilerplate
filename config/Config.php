<?php

namespace Config;

use Dotenv\Dotenv;

class Config
{
    private static $env;

    public static function loadEnv()
    {
        if (!self::$env) {
            $dotenv = Dotenv::createImmutable(__DIR__);
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
}

// Load environment variables
Config::loadEnv();
