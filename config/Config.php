/**
* config/Config.php - Application configuration
*/


<?php

namespace Api\Config;

class Config
{
    // Database configuration
    const DB_HOST = 'localhost';
    const DB_NAME = 'api_db';
    const DB_USER = 'root';
    const DB_PASS = '';

    // API configuration
    const API_VERSION = '1.0.0';
    const API_BASE_PATH = '/api/v1';

    // JWT configuration
    const JWT_SECRET = 'your-secret-key';
    const JWT_EXPIRATION = 3600; // 1 hour

    // Logging configuration
    const LOG_PATH = ROOT_DIR . '/logs';
    const LOG_LEVEL = 'debug'; // debug, info, warning, error
}
