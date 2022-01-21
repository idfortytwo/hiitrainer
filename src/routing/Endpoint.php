<?php

namespace Routing;

use Controllers\IController;

class Endpoint {
    private IController $controller;
    private string $methodName;
//    private array $parameters;

    /**
     * @param IController $controller
     * @param string $methodName
     */
    public function __construct(IController $controller, string $methodName) {
        $this->controller = $controller;
        $this->methodName = $methodName;
    }

    public function getController(): IController {
        return $this->controller;
    }

    public function getMethodName(): string {
        return $this->methodName;
    }

    public function handle() {
        $methodName = $this->methodName;
        $this->controller->$methodName();
        echo $methodName.'<br>';
    }
}
