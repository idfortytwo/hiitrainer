<?php

namespace Routing;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionException;

use Controllers\IController;
use Routing\Endpoints\Endpoint;
use Routing\Endpoints\Parameter;

class RouteInspector {
    private IController $controller;
    private array $routingMap = array();
    private AnnotationReader $reader;

    public function __construct(IController $controller) {
        $this->controller = $controller;
        $this->reader = new AnnotationReader();
    }

    public function getRoutingMap(): array {
        $this->inspectMethods();
        return $this->routingMap;
    }

    private function inspectMethods(): void {
        $controllerRefl = new ReflectionClass(get_class($this->controller));
        foreach ($controllerRefl->getMethods() as $controllerMethod) {
            $this->inspectMethod($controllerMethod);
        }
    }

    private function inspectMethod(ReflectionMethod $controllerMethod): void {
        $annotations = $this->reader->getMethodAnnotations($controllerMethod);
        foreach ($annotations as $route) {
            if ($route instanceof Route) {
                $params = $this->getMethodParams($controllerMethod);
                $endpoint = new Endpoint($this->controller, $controllerMethod->getName(), $params);
                $this->mapEndpoint($route, $endpoint);
            }
        }
    }

    private function getMethodParams(ReflectionMethod $controllerMethod): array {
        $params = array();
        foreach ($controllerMethod->getParameters() as $arg) {
            $name = $arg->getName();
            $type = $arg->getType()->getName();
            $isRequired = !$arg->isOptional();
            $defaultValue = null;
            if (!$isRequired) {
                try {
                    $defaultValue = $arg->getDefaultValue();
                } catch (ReflectionException) {}
            }

            $parameter = new Parameter($name, $type, $isRequired, $defaultValue);
            $params[] = $parameter;
        }
        return $params;
    }

    private function mapEndpoint(Route $route, Endpoint $endpoint): void {
        $path = substr($route->getPath(), 1);
        $pathRegex = $this->parseToRegex($path);

        $methods = $route->getMethods();
        $this->updateRoutingMap($pathRegex, $methods, $endpoint);
    }

    private function parseToRegex(string $path): string {
        $path = preg_replace('(/)', '\/', $path);
        $pattern = '({(.+)})';
        $replacement = '(?P<${1}>\d+)';

        return '(^'.preg_replace($pattern, $replacement, $path).'$)';
    }

    private function updateRoutingMap(string $pathRegex, array $requestMethods, Endpoint $endpoint): void {
        $endpoints = $this->routingMap[$pathRegex] ?? array();
        foreach ($requestMethods as $requestMethod) {
            $endpoints[$requestMethod] = $endpoint;
        }
        $this->routingMap[$pathRegex] = $endpoints;
    }
}
