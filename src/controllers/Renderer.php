<?php

namespace Controllers;

use HTTP\Responses\Response;

abstract class Renderer implements Controller {
    protected function render(string $template = null, array $variables = []): Response {
        $templatePath = 'public/views/'. $template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        return new Response($output);
    }
}
