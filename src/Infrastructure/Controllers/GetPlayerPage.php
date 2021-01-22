<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Application\ViewModel\FaceUpCard;
use ConorSmith\Recollect\Domain\EndOfGameStatus;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\Infrastructure\TemplateEngine;
use ConorSmith\Recollect\UseCases\ShowPlayer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetPlayerPage implements Controller
{
    /** @var ShowPlayer */
    private $useCase;

    /** @var TemplateEngine */
    private $templateEngine;

    public function __construct(ShowPlayer $useCase, TemplateEngine $templateEngine)
    {
        $this->useCase = $useCase;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $player = $this->useCase->__invoke($playerId);

        return new Response($this->templateEngine->render(__DIR__ . "/../Templates/PlayerPage.php", [
            'playerId'               => $playerId->__toString(),
            'faceUpCard'             => FaceUpCard::fromPiles($player->getPlayPile(), $player->getTieBreakerPile()),
            'isTieBreakerPileActive' => !$player->getTieBreakerPile()->isEmpty(),
            'canDrawCard'            => $player->canDrawCard(),
            'canCompeteInFaceOff'    => $player->canCompeteInFaceOff(),
            'canDrawTieBreaker'      => $player->canDrawTieBreaker(),
            'isGameOver'             => $player->isGameOver(),
            'endOfGameStatus'        => $this->getEndOfGameStatus($player->getEndOfGameStatus()),
            'totalCardsWon'          => $player->getWinningPile()->getTotal(),
        ]));
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
            return "It's a draw!";
        }

        // TODO: throw exception
    }
}
