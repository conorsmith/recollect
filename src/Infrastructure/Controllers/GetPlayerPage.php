<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Card;
use ConorSmith\Recollect\Domain\EndOfGameStatus;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\ShowPlayer;
use Ramsey\Uuid\Uuid;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

final class GetPlayerPage
{
    public const METHOD = Request::METHOD_GET;

    public const ROUTE = "/player/*";

    /** @var ShowPlayer */
    private $showPlayPileUseCase;

    public function __construct(ShowPlayer $showPlayPile)
    {
        $this->showPlayPileUseCase = $showPlayPile;
    }

    public function __invoke(Request $request)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $player = $this->showPlayPileUseCase->__invoke($playerId);

        $faceUpCard = $player->getPlayPile()->getFaceUpCard();

        echo $this->renderTemplate(__DIR__ . "/../Templates/PlayerPage.php", [
            'playerId'            => $playerId->__toString(),
            'faceUpCard'          => $this->getFaceUpCard($faceUpCard),
            'canDrawCard'         => $player->canDrawCard(),
            'canCompeteInFaceOff' => $player->canCompeteInFaceOff(),
            'isGameOver'          => $player->isGameOver(),
            'endOfGameStatus'     => $this->getEndOfGameStatus($player->getEndOfGameStatus()),
            'totalCardsWon'       => $player->getWinningPile()->getTotal(),
        ]);
    }

    private function getFaceUpCard(?Card $card): ?stdClass
    {
        if (is_null($card)) {
            return null;
        }

        return (object) [
            'category'     => $this->getCategory($card),
            'symbolColour' => $this->getSymbolColour($card),
        ];
    }

    private const CATEGORIES_BY_CARD_ID = [
        "cc358c78-f6fc-4d17-8723-82a0754ff5b9" => "Aircraft",
        "ff434616-72d8-434c-91d1-7391d3258f61" => "Astronaut",
        "7d39c1db-f943-4f10-88ac-c2579ff96fbe" => "Traffic Sign",
        "2af58062-3bd7-465a-80c3-0f59b48f3661" => "Pet",
        "eeaf6359-9b37-4b2a-9439-b2356a3ea90e" => "Address",
        "58cfa574-dd6c-43ca-8790-f10d32e1fc15" => "Colour",
        "4f6eaf7c-8350-4e1f-9390-bc2893e3fdd3" => "Fairy Tale Character",
        "3ac7d3c1-a541-4fa8-afba-aa16294b83b6" => "Clown",
        "97e1a051-61b1-49aa-9953-c614a2d9e063" => "Shampoo Brand",
        "feb620d3-241a-459b-aed8-8639374a0604" => "Sitcom",
    ];

    private const SYMBOL_COLOURS_BY_ID = [
        "1b96336d-59fa-414d-b29b-b49823b90e14" => "00FF00",
        "b379317c-d4df-4392-ae87-7eb54568387b" => "0000FF",
    ];

    private function getCategory(Card $card): string
    {
        if (!array_key_exists($card->getId()->__toString(), self::CATEGORIES_BY_CARD_ID)) {
            // TODO: throw exception
        }

        return self::CATEGORIES_BY_CARD_ID[$card->getId()->__toString()];
    }

    private function getSymbolColour(Card $card): string
    {
        if (!array_key_exists($card->getSymbol()->getId()->__toString(), self::SYMBOL_COLOURS_BY_ID)) {
            // TODO: throw exception
        }

        return self::SYMBOL_COLOURS_BY_ID[$card->getSymbol()->getId()->__toString()];
    }

    private function getEndOfGameStatus(?EndOfGameStatus $endOfGameStatus): string
    {
        if (is_null($endOfGameStatus)) {
            return "";
        }

        if ($endOfGameStatus->won()) {
            return "You Won!";
        }

        if ($endOfGameStatus->lost()) {
            return "You Lost";
        }

        if ($endOfGameStatus->drew()) {
            return "You Drew";
        }

        // TODO: throw exception
    }

    private function renderTemplate(string $templateFile, array $templateVariables): string
    {
        extract($templateVariables);

        ob_start();

        include $templateFile;

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}
