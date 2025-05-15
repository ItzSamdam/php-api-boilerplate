<?php

namespace Utils;

/**
 * utils/Response.php - Handle HTTP responses
 */

class Response
{
    public static function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success($data, $message = 'Success', $statusCode = 200)
    {
        return self::json([
            'status' => 'success',
            'message' => $message,
            'errors' => null,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message, $statusCode = 400, $errors = [])
    {
        return self::json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'data' => null
        ], $statusCode);
    }

    public static function notFound($message = 'Resource not found')
    {
        return self::error($message, 404);
    }

    public static function unauthorized($message = 'Unauthorized')
    {
        return self::error($message, 401);
    }

    public static function forbidden($message = 'Access Forbidden')
    {
        return self::error($message, 403);
    }

    public static function serverError($message = 'Internal Server Error')
    {
        return self::error($message, 500);
    }

    public static function validationError($errors)
    {
        return self::error('Validation failed', 422, $errors);
    }
}
