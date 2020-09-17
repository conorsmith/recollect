<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\JoinTable;
use Symfony\Component\HttpFoundation\Request;

final class PostJoinTable
{
    /** @var JoinTable */
    private $useCase;

    public function __construct(JoinTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $seatId = $this->useCase->__invoke($_POST['code']);

        header("Location: /seat/{$seatId}");
    }
}
