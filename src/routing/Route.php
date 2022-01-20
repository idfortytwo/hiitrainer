<?php

namespace Routes;

interface IRoute {
    function getPath();
    function getMethods();
}

use Doctrine\Common\Annotations\Annotation;
require_once 'libs/Doctrine/Common/Annotations/Annotation.php';

/**
 * @Annotation
 * @Target({"METHOD"})
 * @Attributes({
 *   @Attribute("path", type = "string"),
 *   @Attribute("methods", type = "array<string>"),
 * })
 */
class Route implements IRoute {
    private string $path;
    private array $methods;

    public function __construct(array $values) {
        $this->path = $values['path'];
        $this->methods = $values['methods'];
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getMethods(): array {
        return $this->methods;
    }
}
