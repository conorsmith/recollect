<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Application\ViewModel\FaceUpCard;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\ShowPlayer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetPlayerStatus implements Controller
{
    /** @var ShowPlayer */
    private $useCase;

    public function __construct(ShowPlayer $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $player = $this->useCase->__invoke($playerId);

        return new Response(json_encode([
            'faceUpCard'          => FaceUpCard::fromPlayPile($player->getPlayPile()),
            'canDrawCard'         => $player->canDrawCard(),
            'canCompeteInFaceOff' => $player->canCompeteInFaceOff(),
            'canDrawTieBreaker'   => $player->canDrawTieBreaker(),
            'isGameOver'          => $player->isGameOver(),
        ]));
    }
}
