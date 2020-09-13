<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\UseCases\StartGame;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class PostStartGame
{
    public const METHOD = Request::METHOD_POST;

    public const ROUTE = "/player/{playerId}/start-game/";

    /** @var StartGame */
    private $useCase;

    public function __construct(StartGame $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $seatId = new SeatId(Uuid::fromString($routeSegments[2]));

        $playerId = $this->useCase->__invoke($seatId);

        header("Location: /player/{$playerId}");
    }
}
