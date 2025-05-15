/**
* services/UserService.php - User service layer
*/
<?php

namespace Api\Services;

use Api\Models\User;
use Api\Config\Config;

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getAllUsers()
    {
        return $this->userModel->findAll();
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
            'exp' => time() + Config::JWT_EXPIRATION
        ];

        // In a real application, you would use a proper JWT library
        $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', "$header.$payloadEncoded", Config::JWT_SECRET, true);
        $signatureEncoded = base64_encode($signature);

        $token = "$header.$payloadEncoded.$signatureEncoded";

        return [
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ],
            'token' => $token,
            'expires_in' => Config::JWT_EXPIRATION
        ];
    }
}
