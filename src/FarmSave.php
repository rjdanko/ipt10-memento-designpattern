<?php

declare(strict_types=1);

namespace App\FarmGame;

use DateTimeImmutable;

/**
 * Concrete Memento. Holds a full, immutable snapshot of the farm.
 * Only Farm should call state().
 */
final class FarmSave implements SaveFile
{
    /**
     * @param array<string, int> $inventory
     */
    public function __construct(
        private readonly int $day,
        private readonly int $gold,
        private readonly int $energy,
        private readonly array $inventory,
        private readonly string $version,
        private readonly DateTimeImmutable $savedAt = new DateTimeImmutable(),
    ) {
    }

    public function day(): int
    {
        return $this->day;
    }

    public function savedAt(): DateTimeImmutable
    {
        return $this->savedAt;
    }

    /**
     * Wide interface, meant for Farm only.
     *
     * @internal
     * @return array{gold: int, energy: int, inventory: array<string, int>, version: string}
     */
    public function state(): array
    {
        return [
            'gold' => $this->gold,
            'energy' => $this->energy,
            'inventory' => $this->inventory,
            'version' => $this->version,
        ];
    }
}
