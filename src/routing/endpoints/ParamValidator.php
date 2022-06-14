<?php

namespace Routing\Endpoints;

class ParamValidator {
    private array $args;
    private array $params;

    public function __construct(array $args, array $params) {
        $this->args = $args;
        $this->params = $params;
    }

    public function validate(): string|null {
        foreach($this->params as $param) {
            /** @var Parameter $param */
            $paramName = $param->getName();

            if ($this->hasParameter($param)) {
                $arg = $this->args[$paramName];
                $paramType = $param->getType();

                if (!$this->hasValidType($arg, $paramType))
                    return 'Parameter "'.$param->getName().'" should have type '.$paramType;

            } else if ($param->isRequired()) {
                return 'Missing required parameter "'.$paramName.'"';
            }
        }
        return null;
    }


    private function hasParameter(Parameter $param): bool {
        return array_key_exists($param->getName(), $this->args);
    }

    private function hasValidType($arg, string $paramType): bool {
        return match ($paramType) {
            'string' => true,
            'int' => filter_var($arg, FILTER_VALIDATE_INT),
            'float' => filter_var($arg, FILTER_VALIDATE_FLOAT),
            'bool' => filter_var($arg, FILTER_VALIDATE_BOOL),
        };
    }
}
