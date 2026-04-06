<?php

/*
 * Copyright © 2025 Samuel Owadayo. All rights reserved.
 */

require_once __DIR__ . '/UserSeeder.php';
require_once __DIR__ . '/ProductSeeder.php';

/**
 * DatabaseSeeder — registers and runs all seeders.
 *
 * Usage (CLI):
 *   php database/seeders/DatabaseSeeder.php
 *   php database/seeders/DatabaseSeeder.php --count=50
 */
class DatabaseSeeder
{
    private array $seeders = [];

    public function register(string $seederClass, int $count): self
    {
        $this->seeders[] = ['class' => $seederClass, 'count' => $count];
        return $this;
    }

    public function run(): void
    {
        echo "=== Database Seeding Started ===" . PHP_EOL;
        $start = microtime(true);

        foreach ($this->seeders as $entry) {
            /** @var BaseSeeder $seeder */
            $seeder = new $entry['class']($entry['count']);
            $seeder->run();
        }

        $elapsed = round(microtime(true) - $start, 2);
        echo "=== Seeding Completed in {$elapsed}s ===" . PHP_EOL;
    }
}

// ── CLI entry point ──────────────────────────────────────────────────────────
if (PHP_SAPI === 'cli' && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    // Support --count=N flag, e.g.: php DatabaseSeeder.php --count=50
    $options = getopt('', ['count:']);
    $count   = isset($options['count']) ? (int) $options['count'] : 20;

    (new DatabaseSeeder())
        ->register(UserSeeder::class, $count)
        ->register(ProductSeeder::class, $count)
        ->run();
}
