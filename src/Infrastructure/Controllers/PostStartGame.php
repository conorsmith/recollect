<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Infrastructure\TemplateEngine;
use ConorSmith\Recollect\UseCases\StartGame;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostStartGame implements Controller
{
    /** @var StartGame */
    private $useCase;

    /** @var TemplateEngine */
    private $templateEngine;

    public function __construct(StartGame $useCase, TemplateEngine $templateEngine)
    {
        $this->useCase = $useCase;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        $seatId = new SeatId(Uuid::fromString($routeParameters['seatId']));

        $result = $this->useCase->__invoke($seatId);

        if (!$result->succeeded()) {
            return new Response(
                $this->templateEngine->render(__DIR__ . "/../Templates/ClientErrorPage.php"),
                Response::HTTP_BAD_REQUEST
            );
        }

        return new RedirectResponse("/player/{$result->getPlayerId()}");
    }
}
