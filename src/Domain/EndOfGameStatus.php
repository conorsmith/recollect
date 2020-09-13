<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class EndOfGameStatus
{
    public static function win(): self
    {
        return new self("win");
    }

    public static function lose(): self
    {
        return new self("lose");
    }

    public static function draw(): self
    {
        return new self("draw");
    }

    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function won(): bool
    {
        return $this->value === "win";
    }

    public function lost(): bool
    {
        return $this->value === "lose";
    }

    public function drew(): bool
    {
        return $this->value === "draw";
    }
}
