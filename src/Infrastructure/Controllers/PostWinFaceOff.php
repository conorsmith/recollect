<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\WinFaceOff;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostWinFaceOff implements Controller
{
    /** @var WinFaceOff */
    private $useCase;

    public function __construct(WinFaceOff $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $this->useCase->__invoke($playerId);

        return new RedirectResponse("/player/{$playerId}");
    }
}
