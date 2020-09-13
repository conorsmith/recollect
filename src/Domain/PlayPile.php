<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class PlayPile
{
    public static function createEmpty(): self
    {
        return new self([]);
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

    public function getFaceUpCard(): ?Card
    {
        if (count($this->cards) === 0) {
            return null;
        }

        return $this->cards[0];
    }

    public function placeAtop(Card $card): void
    {
        array_unshift($this->cards, $card);
    }

    public function takeTopCard(): Card
    {
        return array_shift($this->cards);
    }
}
