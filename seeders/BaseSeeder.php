<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

require_once __DIR__ . '/../vendor/autoload.php';

abstract class BaseSeeder
{
    protected \Faker\Generator $faker;
    protected int $count;

    public function __construct(int $count = 10)
    {
        $this->faker = \Faker\Factory::create();
        $this->count = $count;
    }

    /**
     * Run the seeder. Must be implemented by each concrete seeder.
     */
    abstract public function run(): void;

    /**
     * Seed N records using a callback that returns a data array.
     */
    protected function seedMany(callable $factory, string $modelClass): void
    {
        /** @var \BaseModel $model */
        $model = new $modelClass();

        $success = 0;
        $failed  = 0;

        for ($i = 0; $i < $this->count; $i++) {
            $data = $factory($this->faker, $i);

            try {
                $model->create($data);
                $success++;
            } catch (\Exception $e) {
                $failed++;
                echo "[{$modelClass}] Row {$i} failed: " . $e->getMessage() . PHP_EOL;
            }
        }

        echo "[{$modelClass}] Seeded {$success} records" .
            ($failed ? ", {$failed} failed" : "") . "." . PHP_EOL;
    }
}


# Seed 20 of each (default)
// php database/seeders/DatabaseSeeder.php

# Seed 100 of each
// php database/seeders/DatabaseSeeder.php --count=100