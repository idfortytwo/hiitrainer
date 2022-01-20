<?php

use JetBrains\PhpStorm\Pure;

require_once 'src/routing/Router.php';
require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/ExerciseController.php';

class Routing {
    private Router $router;
    private array $controllers;

    #[Pure] public function __construct() {
        $this->router = new Router();
        $this->controllers = [
            DefaultController::class,
            ExerciseController::class
        ];
    }

    public function setup() {
        foreach ($this->controllers as $controllerClass) {
            $controller = new $controllerClass();
            $this->router->register($controller);
        }
    }

    public function run(string $url) {
        $this->router->run($url);
    }
}

