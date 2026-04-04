<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

namespace Services;

require_once __DIR__ . '/../models/User.php';

use Config\Config;
use Utils\Paginator;
use Utils\TokenService;
use User;

class UserService
{
    public function getAllUsers($page, $default)
    {
        $data = User::query()->get();
        return new Paginator($data, $default, $page);
    }

    public function getUserById($id)
    {
        return User::query()->find($id);
    }

    public function createUser($data)
    {
        // Hash password before saving
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['token_version'] = 0; // default

        return User::query()->create($data);
    }

    public function updateUser($id, $data)
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return User::query()->update($id, $data);
    }

    public function deleteUser($id)
    {
        return User::query()->delete($id);
    }

    public function login($email, $password)
    {
        $user = User::query()->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $other_info = [
            'name' => $user['name'],
            'email' => $user['email'],
            'verified' => $user['verified'] ?? false,
            'role' => $user['role'] ?? 'user',
            // add other info as needed
        ];

        $token = TokenService::issueTokens(\Database::getInstance()->getConnection(), $user['id'], $other_info);

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
