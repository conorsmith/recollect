<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Infrastructure\TemplateEngine;
use ConorSmith\Recollect\UseCases\JoinTable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostJoinTable implements Controller
{
    /** @var JoinTable */
    private $useCase;

    /** @var TemplateEngine */
    private $templateEngine;

    public function __construct(JoinTable $useCase, TemplateEngine $templateEngine)
    {
        $this->useCase = $useCase;
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        if (!$request->request->has('code')
            || $request->request->get('code') === ""
        ) {
            return new Response(
                $this->templateEngine->render(__DIR__ . "/../Templates/ClientErrorPage.php"),
                Response::HTTP_BAD_REQUEST
            );
        }

        $seatId = $this->useCase->__invoke($request->request->get('code'));

        return new RedirectResponse("/seat/{$seatId}");
    }
}
