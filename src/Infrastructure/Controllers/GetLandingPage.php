<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use Symfony\Component\HttpFoundation\Request;

final class GetLandingPage
{
    public const METHOD = Request::METHOD_GET;

    public const ROUTE = "/";

    public function __invoke()
    {
        echo $this->renderTemplate();
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
