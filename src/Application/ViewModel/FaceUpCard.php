<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\ViewModel;

use ConorSmith\Recollect\Domain\Card;
use ConorSmith\Recollect\Domain\PlayPile;

final class FaceUpCard
{
    private const SYMBOL_COLOURS_BY_ID = [
        "2ad73bfd-9cf5-45c7-89dc-862f3e6fc4af" => "FF0000",
        "1b96336d-59fa-414d-b29b-b49823b90e14" => "00FF00",
        "b379317c-d4df-4392-ae87-7eb54568387b" => "0000FF",
    ];

    public static function fromPlayPile(PlayPile $playPile): ?self
    {
        $card = $playPile->getFaceUpCard();

        if (is_null($card)) {
            return null;
        }

        return new self($card);
    }

    /** @var string */
    public $category;

    /** @var string */
    public $symbolColour;

    public function __construct(Card $card)
    {
        $cardConfig = $this->getCardsConfig();

        if (!array_key_exists($card->getId()->__toString(), $cardConfig)) {
            // TODO: throw exception
        }

        if (!array_key_exists($card->getSymbol()->getId()->__toString(), self::SYMBOL_COLOURS_BY_ID)) {
            // TODO: throw exception
        }

        $this->category = $cardConfig[$card->getId()->__toString()]['category'];
        $this->symbolColour = self::SYMBOL_COLOURS_BY_ID[$card->getSymbol()->getId()->__toString()];
    }

    private function getCardsConfig(): array
    {
        return require __DIR__ . "/../../../config/cards.php";
    }
}
