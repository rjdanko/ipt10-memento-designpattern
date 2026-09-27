<?php

declare(strict_types=1);

namespace App\FarmGame;

use InvalidArgumentException;
use RuntimeException;

/**
 * Originator: the farm owns its state and the rules that change it.
 */
final class Farm
{
    private const VERSION = '1.2';
    private const MAX_ENERGY = 270;

    private int $day = 1;
    private int $gold = 500;
    private int $energy = self::MAX_ENERGY;

    /** @var array<string, int> */
    private array $inventory = [];

    public function harvest(string $crop, int $qty): void
    {
        $cost = 2 * $qty;
        if ($cost > $this->energy) {
            throw new RuntimeException('Too tired to harvest that much.');
        }
        $this->energy -= $cost;
        $this->inventory[$crop] = ($this->inventory[$crop] ?? 0) + $qty;
    }

    public function sell(string $crop, int $qty, int $price): void
    {
        if (($this->inventory[$crop] ?? 0) < $qty) {
            throw new InvalidArgumentException("Not enough {$crop} to sell.");
        }
        $this->inventory[$crop] -= $qty;
        if ($this->inventory[$crop] === 0) {
            unset($this->inventory[$crop]);
        }
        $this->gold += $qty * $price;
    }

    /**
     * Ending the day is the only way to create a save.
     */
    public function sleep(): SaveFile
    {
        $this->day++;
        $this->energy = self::MAX_ENERGY;

        return new FarmSave($this->day, $this->gold, $this->energy, $this->inventory, self::VERSION);
    }

    public function load(SaveFile $save): void
    {
        if (!$save instanceof FarmSave) {
            throw new InvalidArgumentException('Not a save file from this game.');
        }
        $state = $save->state();
        if (version_compare($state['version'], self::VERSION, '>')) {
            throw new RuntimeException('Save was made by a newer version of the game.');
        }
        $this->day = $save->day();
        $this->gold = $state['gold'];
        $this->energy = $state['energy'];
        $this->inventory = $state['inventory'];
    }

    public function status(): string
    {
        $items = [];
        foreach ($this->inventory as $crop => $qty) {
            $items[] = "{$crop} x{$qty}";
        }

        return sprintf(
            'Day %d | %dg | energy %d | %s',
            $this->day,
            $this->gold,
            $this->energy,
            $items === [] ? 'empty bag' : implode(', ', $items)
        );
    }
}
