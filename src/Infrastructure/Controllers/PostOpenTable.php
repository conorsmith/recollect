<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\OpenTable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostOpenTable
{
    /** @var OpenTable */
    private $useCase;

    public function __construct(OpenTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $seatId = $this->useCase->__invoke();

        return new RedirectResponse("/seat/{$seatId}");
    }
}
