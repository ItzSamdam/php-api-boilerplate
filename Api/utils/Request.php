/**
* utils/Request.php - Handle HTTP requests
*/
<?php

namespace Api\Utils;

class Request
{
    private $method;
    private $path;
    private $params;
    private $body;
    private $headers;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = $this->parsePath();
        $this->params = $this->parseParams();
        $this->body = $this->parseBody();
        $this->headers = $this->parseHeaders();
    }

    private function parsePath()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    private function parseParams()
    {
        $params = [];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            foreach ($_GET as $key => $value) {
                $params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $params;
    }

    private function parseBody()
    {
        $body = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
            $input = file_get_contents('php://input');
            $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

            if (strpos($contentType, 'application/json') !== false) {
                $body = json_decode($input, true);
            } else {
                parse_str($input, $body);
            }
        }

        return $body;
    }

    private function parseHeaders()
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerKey = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$headerKey] = $value;
            }
        }

        return $headers;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getParam($key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getBodyParam($key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    public function getHeader($key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getAuthorizationHeader()
    {
        return $this->getHeader('Authorization', '');
    }
}
