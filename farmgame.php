<?php

declare(strict_types=1);

use App\FarmGame\Farm;
use App\FarmGame\SaveSlot;

// Use Composer's autoloader if installed, otherwise a minimal PSR-4 fallback.
if (is_file(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'App\\FarmGame\\';
        if (str_starts_with($class, $prefix)) {
            require __DIR__ . '/src/' . substr($class, strlen($prefix)) . '.php';
        }
    });
}

$farm = new Farm();
$slot = new SaveSlot();

// Day 1: harvest, sell, then go to bed (this creates the save).
$farm->harvest('parsnip', 15);
$farm->sell('parsnip', 15, 35);
$slot->store($farm->sleep());
echo 'After sleeping:  ' . $farm->status() . PHP_EOL;

// Day 2: progress that has not been saved yet.
$farm->harvest('parsnip', 40);
$farm->sell('parsnip', 20, 35);
echo 'Mid-day:         ' . $farm->status() . PHP_EOL;

// The player quits without going to bed, then opens the game again.
echo 'Load menu:       ' . $slot->menu() . PHP_EOL;
$farm->load($slot->latest());
echo 'After reloading: ' . $farm->status() . PHP_EOL;
