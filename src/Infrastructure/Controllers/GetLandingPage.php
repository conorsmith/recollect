<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetLandingPage implements Controller
{
    public function __invoke(Request $request, array $routeParameters): Response
    {
        return new Response($this->renderTemplate());
    }

    private function renderTemplate(): string
    {
        ob_start();

        include __DIR__ . "/../Templates/LandingPage.php";

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}
