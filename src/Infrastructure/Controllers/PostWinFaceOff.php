<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\WinFaceOff;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class PostWinFaceOff
{
    /** @var WinFaceOff */
    private $useCase;

    public function __construct(WinFaceOff $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $this->useCase->__invoke($playerId);

        header("Location: /player/{$playerId}");
    }
}
