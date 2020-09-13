<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\UseCases\OpenTable;
use Symfony\Component\HttpFoundation\Request;

final class PostOpenTable
{
    public const METHOD = Request::METHOD_POST;

    public const ROUTE = "/open-table";

    /** @var OpenTable */
    private $useCase;

    public function __construct(OpenTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke()
    {
        $seatId = $this->useCase->__invoke();

        header("Location: /seat/{$seatId}");
    }
}
