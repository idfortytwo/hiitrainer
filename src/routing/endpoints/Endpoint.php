<?php

namespace Routing\Endpoints;

use Controllers\Controller;
use HTTP\Responses\IResponse;
use HTTP\Responses\JSONResponse;

class Endpoint {
    private Controller $controller;
    private string $methodName;
    private array $methodParams;

    /**
     * @param Controller $controller
     * @param string $methodName
     * @param array $methodParams
     */
    public function __construct(Controller $controller, string $methodName, array $methodParams) {
        $this->controller = $controller;
        $this->methodName = $methodName;
        $this->methodParams = $methodParams;
    }

    public function getController(): Controller {
        return $this->controller;
    }

    public function getMethodName(): string {
        return $this->methodName;
    }

    public function getMethodParams(): array {
        return $this->methodParams;
    }

    public function handle(array $args) : IResponse {
        $validator = new ParamValidator($args, $this->methodParams);
        $validationResult = $validator->validate();

        if (empty($validationResult)) {
            $methodName = $this->methodName;
            return $this->controller->$methodName(...$args);
        } else {
            return new JSONResponse([
                'message' => $validationResult
            ], 400);
        }
    }
}
