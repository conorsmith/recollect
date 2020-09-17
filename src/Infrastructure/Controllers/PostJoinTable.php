<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\JoinTable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostJoinTable
{
    /** @var JoinTable */
    private $useCase;

    public function __construct(JoinTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $seatId = $this->useCase->__invoke($_POST['code']);

        return new RedirectResponse("/seat/{$seatId}");
    }
}
