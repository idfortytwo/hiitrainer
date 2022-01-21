<?php

namespace Routing\Endpoints;

class Parameter {
    private string $name;
    private string $type;
    private bool $isRequired;
    private mixed $defaultValue;

    public function __construct(string $name, string $type, bool $isRequired, mixed $defaultValue = null) {
        $this->name = $name;
        $this->type = $type;
        $this->isRequired = $isRequired;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool {
        return $this->isRequired;
    }

    /**
     * @return mixed|null
     */
    public function getDefaultValue(): mixed {
        return $this->defaultValue;
    }

    public function __toString(): string {
        $isRequired = $this->isRequired != null ? 'true' : 'false';
        $defaultValue = $this->defaultValue != null ? $this->defaultValue : 'null';
        return "Parameter(name: '{$this->name}', type: {$this->type}, 
                          isRequired: {$isRequired}, defaultValue: {$defaultValue})";
    }
}
