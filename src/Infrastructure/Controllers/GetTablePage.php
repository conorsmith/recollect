<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Infrastructure\TemplateEngine;
use ConorSmith\Recollect\UseCases\ShowTable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetTablePage implements Controller
{
    /** @var ShowTable */
    private $useCase;

    /** @var TemplateEngine */
    private $templateEngine;

    public function __construct(ShowTable $useCase, TemplateEngine $templateEngine)
    {
        $this->useCase = $useCase;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $seatId = new SeatId(Uuid::fromString($routeSegments[2]));

        $table = $this->useCase->__invoke($seatId);

        if (!$table->isOpen()) {
            return new RedirectResponse("/player/{$table->getSeat($seatId)->getPlayerId()}");
        }

        return new Response($this->templateEngine->render(__DIR__ . "/../Templates/TablePage.php", [
            'seatId'          => $seatId->__toString(),
            'joinCode'        => $table->getCode(),
            'numberOfPlayers' => count($table->getSeats()),
        ]));
    }
}
