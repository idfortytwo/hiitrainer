<?php

namespace Routing;

use JetBrains\PhpStorm\Pure;

use Controllers\DefaultController;
use Controllers\ExerciseController;

class Routing {
    private Router $router;
    private array $controllers;

    #[Pure] public function __construct() {
        $this->router = new Router();
        $this->controllers = [
            new DefaultController(),
            new ExerciseController()
        ];
    }

    public function setup() {
        foreach ($this->controllers as $controller) {
            $this->router->register($controller);
        }
    }

    public function run(string $url, string $requestMethod) {
        $this->router->run($url, $requestMethod);
    }
}

