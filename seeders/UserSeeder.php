<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

require_once __DIR__ . '/BaseSeeder.php';
require_once __DIR__ . '/../models/User.php'; // adjust path as needed

class UserSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->seedMany(function (\Faker\Generator $faker) {
            return [
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => password_hash($faker->password(minLength: 8), PASSWORD_BCRYPT),
            ];
        }, User::class);
    }
}
