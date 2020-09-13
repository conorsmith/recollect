<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class DrawPile
{
    public static function generate(): self
    {
        $cards = (new Deck)->all();

        shuffle($cards);

        return new self($cards);
    }

    /** @var array */
    private $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function draw(): Card
    {
        if ($this->isEmpty()) {
            // TODO: Throw exception, the game's over
        }

        return array_shift($this->cards);
    }

    public function isEmpty(): bool
    {
        return count($this->cards) === 0;
    }
}
