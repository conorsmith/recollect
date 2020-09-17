<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\OpenTable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class PostOpenTable
{
    /** @var OpenTable */
    private $useCase;

    public function __construct(OpenTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $seatId = $this->useCase->__invoke();

        $response = new RedirectResponse("/seat/{$seatId}");

        $response->send();
    }
}
