<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Infrastructure\TemplateEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetLandingPage implements Controller
{
    /** @var TemplateEngine */
    private $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(Request $request, array $routeParameters): Response
    {
        return new Response(
            $this->templateEngine->render(__DIR__ . "/../Templates/LandingPage.php")
        );
    }
}
