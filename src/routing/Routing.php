<?php

namespace Routing;

use Controllers\API\ExerciseAPI;
use Controllers\API\WorkoutAPI;
use Controllers\Renderers\DefaultRenderer;

class Routing {
    private Router $router;
    private array $controllers;

    public function __construct() {
        $this->router = new Router();
        $this->controllers = [
            new DefaultRenderer(),
            new ExerciseAPI(),
            new WorkoutAPI()
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

