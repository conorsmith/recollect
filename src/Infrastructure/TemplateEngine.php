<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure;

final class TemplateEngine
{
    public function render(string $templateFile, array $templateVariables = []): string
    {
        return $this->renderTemplate(
            __DIR__ . "/Templates/Layout.php",
            [
                'content' => $this->renderTemplate($templateFile, $templateVariables),
            ]
        );
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
