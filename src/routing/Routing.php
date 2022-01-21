<?php

require_once 'src/routing/Router.php';
require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/ExerciseController.php';

class Routing {
    private Router $router;
    private array $controllers;

    public function __construct() {
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

