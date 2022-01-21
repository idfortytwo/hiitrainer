<?php

namespace Routing\Endpoints;

use Controllers\IController;

class Endpoint {
    private IController $controller;
    private string $methodName;
    private array $methodParams;

    /**
     * @param IController $controller
     * @param string $methodName
     * @param array $methodParams
     */
    public function __construct(IController $controller, string $methodName, array $methodParams) {
        $this->controller = $controller;
        $this->methodName = $methodName;
        $this->methodParams = $methodParams;
    }

    public function getController(): IController {
        return $this->controller;
    }

    public function getMethodName(): string {
        return $this->methodName;
    }

    public function getMethodParams(): array {
        return $this->methodParams;
    }

    public function handle(array $args) {
        $methodName = $this->methodName;

        $validator = new ParamValidator($args, $this->methodParams);
        $validationResponse = $validator->validate();
        if (empty($validationResponse)) {
            $this->controller->$methodName(...$args);
        } else {
            echo $validationResponse;
        }
    }
}
