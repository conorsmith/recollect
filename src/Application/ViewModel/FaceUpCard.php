<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\ViewModel;

use ConorSmith\Recollect\Domain\Card;
use ConorSmith\Recollect\Domain\PlayPile;
use ConorSmith\Recollect\Domain\TieBreakerPile;

final class FaceUpCard
{
    private const SYMBOL_TEMPLATES_BY_ID = [
        "f7803b09-8170-4bbd-a6e3-c946ab0da1d8" => "Asterisk",
        "b379317c-d4df-4392-ae87-7eb54568387b" => "Circle",
        "2ad73bfd-9cf5-45c7-89dc-862f3e6fc4af" => "Diamond",
        "42cc6267-6435-4ac9-a93e-c09fd2e84bdb" => "Dots",
        "6df3a20a-7e07-4242-82b2-eb8075217e5a" => "Grate",
        "abfcf027-921c-46f5-be0c-88b56a6c4500" => "Lines",
        "1b96336d-59fa-414d-b29b-b49823b90e14" => "Plus",
        "06382e60-0878-4150-8be9-ec172207b0e7" => "Waves",
    ];

    public static function fromPiles(PlayPile $playPile, TieBreakerPile $tieBreakerPile): ?self
    {
        $card = $tieBreakerPile->getFaceUpCard();

        if (!is_null($card)) {
            return new self($card);
        }

        $card = $playPile->getFaceUpCard();

        if (!is_null($card)) {
            return new self($card);
        }

        return null;
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

        if (!array_key_exists($card->getSymbol()->getId()->__toString(), self::SYMBOL_TEMPLATES_BY_ID)) {
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
