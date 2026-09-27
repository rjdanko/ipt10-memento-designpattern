<?php

declare(strict_types=1);

namespace App\FarmGame;

use DateTimeImmutable;

/**
 * Narrow interface of the Memento: only what a load menu needs to display.
 * The Caretaker (SaveSlot) depends on this type and nothing else.
 */
interface SaveFile
{
    public function day(): int;

    public function savedAt(): DateTimeImmutable;
}
