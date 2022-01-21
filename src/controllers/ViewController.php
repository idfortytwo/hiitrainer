<?php

require_once 'IController.php';

abstract class ViewController implements IController {
    protected function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/'. $template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}
