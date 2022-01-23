<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use HTTP\Responses\Response;
use Routing\Route;

class DefaultRenderer extends Renderer {
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function root() : Response {
        return new Response('at root');
    }

    /**
     * @Route(path="/", methods={"POST"})
     */
    public function rootPost() : Response {
        return new Response('posting at root');
    }

    /**
     * @Route(path="/hello", methods={"GET", "POST"})
     */
    public function hello(string $name, int $age=null) : Response {
        $content = 'Greetings, '.$name;
        if ($age != null) {
            $content .= ' of age '.$age;
        }
        $content .= '!<br>';

        return new Response($content);
    }
}
