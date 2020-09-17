<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\UseCases\ShowTable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class GetTablePage
{
    /** @var ShowTable */
    private $useCase;

    public function __construct(ShowTable $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(Request $request, array $routeParameters)
    {
        $routeSegments = explode("/", $request->getPathInfo());

        $seatId = new SeatId(Uuid::fromString($routeSegments[2]));

        $table = $this->useCase->__invoke($seatId);

        if (!$table->isOpen()) {
            header("Location: /player/{$table->getSeat($seatId)->getPlayerId()}");
            return;
        }

        echo $this->renderTemplate(__DIR__ . "/../Templates/TablePage.php", [
            'seatId'          => $seatId->__toString(),
            'joinCode'        => $table->getCode(),
            'numberOfPlayers' => count($table->getSeats()),
        ]);
    }

    private function renderTemplate(string $templateFile, array $templateVariables): string
    {
        extract($templateVariables);

        ob_start();

        include $templateFile;

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}
