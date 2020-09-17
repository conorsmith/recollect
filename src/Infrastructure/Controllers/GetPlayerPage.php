<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Application\ViewModel\FaceUpCard;
use ConorSmith\Recollect\Domain\EndOfGameStatus;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\ShowPlayer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetPlayerPage
{
    /** @var ShowPlayer */
    private $useCase;

    public function __construct(ShowPlayer $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $player = $this->useCase->__invoke($playerId);

        $response = new Response($this->renderTemplate(__DIR__ . "/../Templates/PlayerPage.php", [
            'playerId'            => $playerId->__toString(),
            'faceUpCard'          => FaceUpCard::fromPlayPile($player->getPlayPile()),
            'canDrawCard'         => $player->canDrawCard(),
            'canCompeteInFaceOff' => $player->canCompeteInFaceOff(),
            'isGameOver'          => $player->isGameOver(),
            'endOfGameStatus'     => $this->getEndOfGameStatus($player->getEndOfGameStatus()),
            'totalCardsWon'       => $player->getWinningPile()->getTotal(),
        ]));

        $response->send();
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
