<?php

declare(strict_types=1);

namespace App\FarmGame;

use RuntimeException;

/**
 * Caretaker: keeps saves and draws the load menu, never reads the state.
 */
final class SaveSlot
{
    /** @var list<SaveFile> */
    private array $saves = [];

    public function __construct(private readonly int $keep = 1)
    {
    }

    public function store(SaveFile $save): void
    {
        $this->saves[] = $save;
        if (count($this->saves) > $this->keep) {
            array_shift($this->saves);
        }
    }

    public function latest(): SaveFile
    {
        if ($this->saves === []) {
            throw new RuntimeException('No save in this slot.');
        }

        return $this->saves[array_key_last($this->saves)];
    }

    public function menu(): string
    {
        $save = $this->latest();

        return sprintf('Day %d (saved %s)', $save->day(), $save->savedAt()->format('H:i'));
    }
}
