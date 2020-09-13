<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

use Ramsey\Uuid\Uuid;

final class Deck
{
    public function all(): array
    {
        return [
            new Card(
                new CardId(Uuid::fromString("cc358c78-f6fc-4d17-8723-82a0754ff5b9")),
                new Symbol(Uuid::fromString("1b96336d-59fa-414d-b29b-b49823b90e14"))
            ),
            new Card(
                new CardId(Uuid::fromString("ff434616-72d8-434c-91d1-7391d3258f61")),
                new Symbol(Uuid::fromString("b379317c-d4df-4392-ae87-7eb54568387b"))
            ),
            new Card(
                new CardId(Uuid::fromString("7d39c1db-f943-4f10-88ac-c2579ff96fbe")),
                new Symbol(Uuid::fromString("b379317c-d4df-4392-ae87-7eb54568387b"))
            ),
            new Card(
                new CardId(Uuid::fromString("2af58062-3bd7-465a-80c3-0f59b48f3661")),
                new Symbol(Uuid::fromString("1b96336d-59fa-414d-b29b-b49823b90e14"))
            ),
            new Card(
                new CardId(Uuid::fromString("eeaf6359-9b37-4b2a-9439-b2356a3ea90e")),
                new Symbol(Uuid::fromString("1b96336d-59fa-414d-b29b-b49823b90e14"))
            ),
            new Card(
                new CardId(Uuid::fromString("58cfa574-dd6c-43ca-8790-f10d32e1fc15")),
                new Symbol(Uuid::fromString("1b96336d-59fa-414d-b29b-b49823b90e14"))
            ),
            new Card(
                new CardId(Uuid::fromString("4f6eaf7c-8350-4e1f-9390-bc2893e3fdd3")),
                new Symbol(Uuid::fromString("b379317c-d4df-4392-ae87-7eb54568387b"))
            ),
            new Card(
                new CardId(Uuid::fromString("3ac7d3c1-a541-4fa8-afba-aa16294b83b6")),
                new Symbol(Uuid::fromString("b379317c-d4df-4392-ae87-7eb54568387b"))
            ),
            new Card(
                new CardId(Uuid::fromString("97e1a051-61b1-49aa-9953-c614a2d9e063")),
                new Symbol(Uuid::fromString("1b96336d-59fa-414d-b29b-b49823b90e14"))
            ),
            new Card(
                new CardId(Uuid::fromString("feb620d3-241a-459b-aed8-8639374a0604")),
                new Symbol(Uuid::fromString("b379317c-d4df-4392-ae87-7eb54568387b"))
            ),
        ];
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
