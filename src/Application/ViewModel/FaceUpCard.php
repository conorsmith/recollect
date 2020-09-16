<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\ViewModel;

use ConorSmith\Recollect\Domain\Card;
use ConorSmith\Recollect\Domain\PlayPile;

final class FaceUpCard
{
    private const SYMBOL_TEMPLATES_BY_ID = [
        "2ad73bfd-9cf5-45c7-89dc-862f3e6fc4af" => "Diamond",
        "1b96336d-59fa-414d-b29b-b49823b90e14" => "Square",
        "b379317c-d4df-4392-ae87-7eb54568387b" => "Circle",
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
    public $symbolId;

    /** @var string */
    public $symbolTemplate;

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
        $this->symbolId = $card->getSymbol()->getId()->__toString();
        $this->symbolTemplate = __DIR__ . "/../../Infrastructure/Templates/Symbols/" . self::SYMBOL_TEMPLATES_BY_ID[$card->getSymbol()->getId()->__toString()] . ".php";
    }

    private function getCardsConfig(): array
    {
        return require __DIR__ . "/../../../config/cards.php";
    }
}
