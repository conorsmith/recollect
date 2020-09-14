<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

use Ramsey\Uuid\Uuid;

final class Deck
{
    public function all(): array
    {
        $cardsConfig = require __DIR__ . "/../../config/cards.php";

        $cards = [];

        foreach ($cardsConfig as $cardId => $configValues) {
            $cards[] = new Card(
                new CardId(Uuid::fromString($cardId)),
                new Symbol(Uuid::fromString($configValues['symbol']))
            );
        }

        return $cards;
    }

    public function findCard(CardId $cardId): ?Card
    {
        /** @var Card $card */
        foreach ($this->all() as $card) {
            if ($card->getId()->equals($cardId)) {
                return $card;
            }
        }

        return null;
    }
}
