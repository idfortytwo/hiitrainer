<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Routing\IRoute;
use Routing\Endpoint;

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

    private function inspectMethod($controllerMethod) {
        $annotations = $this->reader->getMethodAnnotations($controllerMethod);
        foreach ($annotations as $route) {
            if ($route instanceof IRoute) {
                $endpoint = new Endpoint($this->controller, $controllerMethod->getName());
                $this->mapEndpoint($route, $endpoint);
            }
        }
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
