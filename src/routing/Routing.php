<?php

namespace Routing;

use Controllers\DefaultController;
use Controllers\ExerciseController;
use Controllers\WorkoutController;

class Routing {
    private Router $router;
    private array $controllers;

    public function __construct() {
        $this->router = new Router();
        $this->controllers = [
            new DefaultController(),
            new ExerciseController(),
            new WorkoutController()
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

