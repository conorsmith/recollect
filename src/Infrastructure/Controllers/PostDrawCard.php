<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\UseCases\DrawCard;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class PostDrawCard
{
    /** @var DrawCard */
    private $useCase;

    public function __construct(DrawCard $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $playerId = new PlayerId(Uuid::fromString($routeSegments[2]));

        $this->useCase->__invoke($playerId);

        $response = new RedirectResponse("/player/{$playerId}");

        $response->send();
    }
}
