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

    public function getRoutingMap() : array {
        $this->inspectMethods();
        return $this->routingMap;
    }

    private function inspectMethods() {
        $controllerRefl = new ReflectionClass(get_class($this->controller));
        foreach ($controllerRefl->getMethods() as $controllerMethod) {
            $this->inspectMethod($controllerMethod);
        }
    }

    private function inspectMethod(ReflectionMethod $controllerMethod) {
        $annotations = $this->reader->getMethodAnnotations($controllerMethod);
        foreach ($annotations as $route) {
            if ($route instanceof IRoute) {
                $params = $this->getMethodParams($controllerMethod);
                $endpoint = new Endpoint($this->controller, $controllerMethod->getName(), $params);
                $this->mapEndpoint($route, $endpoint);
            }
        }
    }

    private function getMethodParams(ReflectionMethod $controllerMethod) : array {
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

    private function mapEndpoint(IRoute $route, Endpoint $endpoint) {
        $url = substr($route->getPath(), 1);
        $methods = $route->getMethods();
        $this->updateRoutingMap($url, $methods, $endpoint);
    }

    private function updateRoutingMap(string $url, array $requestMethods, Endpoint $endpoint) {
        $endpoints = $this->routingMap[$url] ?? array();
        foreach ($requestMethods as $requestMethod)
            $endpoints[$requestMethod] = $endpoint;
        $this->routingMap[$url] = $endpoints;
    }
}
