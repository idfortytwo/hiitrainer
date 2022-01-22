<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use Routing\Route;

class DefaultRenderer extends Renderer {
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function root() {
        echo 'at root';
    }

    /**
     * @Route(path="/", methods={"POST"})
     */
    public function rootPost() {
        echo 'posting at root';
    }

    /**
     * @Route(path="/hello", methods={"GET", "POST"})
     */
    public function hello(string $name, int $age=null) {
        echo 'Greetings, '.$name;
        if ($age != null) {
            echo ' of age '.$age;
        }
        echo '!<br>';
    }
}
