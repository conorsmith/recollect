<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Application\ViewModel\FaceUpCard;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\ShowPlayer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class GetPlayerStatus
{
    public const METHOD = Request::METHOD_GET;

    public const ROUTE = "/player/{playerId}/status";

    /** @var ShowPlayer */
    private $useCase;

    public function __construct(ShowPlayer $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $player = $this->useCase->__invoke($playerId);

        echo json_encode([
            'faceUpCard'          => FaceUpCard::fromPlayPile($player->getPlayPile()),
            'canDrawCard'         => $player->canDrawCard(),
            'canCompeteInFaceOff' => $player->canCompeteInFaceOff(),
            'isGameOver'          => $player->isGameOver(),
        ]);
    }
}
