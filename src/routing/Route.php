<?php

namespace Routes;

interface IRoute {
    function getPath();
    function getMethod();
}

use Doctrine\Common\Annotations\Annotation;
require_once 'libs/Doctrine/Common/Annotations/Annotation.php';

/**
 * @Annotation
 * @Target({"METHOD"})
 * @Attributes({
 *   @Attribute("path", type = "string"),
 *   @Attribute("method",  type = "string"),
 * })
 */
class Route implements IRoute {
    private string $path;
    private string $method;

    public function __construct(array $values) {
        $this->path = $values['path'];
        $this->method = $values['method'];
    }
    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }
}
