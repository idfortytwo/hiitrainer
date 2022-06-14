<?php

namespace Routing;

use Controllers\API\AuthAPI;
use Controllers\API\ExerciseAPI;
use Controllers\API\WorkoutAPI;
use Controllers\Renderers\AuthRenderer;
use Controllers\Renderers\DefaultRenderer;
use Controllers\Renderers\WorkoutRenderer;
use HTTP\Requests\Request;
use HTTP\Responses\IResponse;

class Routing {
    private Router $router;
    private array $controllers;

    public function __construct() {
        $this->router = new Router();
        $this->controllers = [
            new DefaultRenderer(),
            new ExerciseAPI(),
            new WorkoutAPI(),
            new WorkoutRenderer(),
            new AuthRenderer(),
            new AuthAPI()
        ];
    }

    public function setup(): void {
        foreach ($this->controllers as $controller) {
            $this->router->register($controller);
        }
    }

    public function run(Request $request): IResponse {
        return $this->router->run($request);
    }
}

