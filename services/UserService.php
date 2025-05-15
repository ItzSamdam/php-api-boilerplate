<?php

namespace Services;

require_once __DIR__ . '/../models/User.php';

use Config\Config;
use Utils\Paginator;
use User;

class UserService
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->db = \Database::getInstance()->getConnection();
        $this->userModel = new User($this->db);
    }

    public function getAllUsers($page, $default)
    {       
        $data = $this->userModel->findAll();
        $response = new Paginator($data, $default, $page);
        return $response;
    }



    public function getUserById($id)
    {
        return $this->userModel->findById($id);
    }

    public function createUser($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->userModel->create($data);
    }

    public function updateUser($id, $data)
    {
        // Hash password if it exists
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->userModel->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userModel->delete($id);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        // Create JWT token (simplified example)
        $payload = [
            'sub' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + Config::getJwtExpiration()
        ];

        // In a real application, you would use a proper JWT library
        $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', "$header.$payloadEncoded", Config::getJwtSecret(), true);
        $signatureEncoded = base64_encode($signature);

        $token = "$header.$payloadEncoded.$signatureEncoded";

        return [
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ],
            'token' => $token,
            'expires_in' => Config::getJwtExpiration()
        ];
    }
}
