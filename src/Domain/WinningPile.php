<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class WinningPile
{
    public static function createEmpty(): self
    {
        return new self(0);
    }

    /** @var int */
    private $total;

    public function __construct(int $total)
    {
        $this->total = $total;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function add(Card $card): void
    {
        $this->total++;
    }

    public function beats(self $other): bool
    {
        return $this->total > $other->total;
    }

    public function matches(self $other): bool
    {
        return $this->total === $other->total;
    }
}
