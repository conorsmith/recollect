<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\JoinTable;
use Symfony\Component\HttpFoundation\Request;

final class PostJoinTable
{
    public const METHOD = Request::METHOD_POST;

    public const ROUTE = "/join-table";

    /** @var JoinTable */
    private $useCase;

    public function __construct(JoinTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request)
    {
        $seatId = $this->useCase->__invoke($_POST['code']);

        header("Location: /seat/{$seatId}");
    }
}
