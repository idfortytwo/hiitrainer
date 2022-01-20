<?php

class Router {
    public array $routes = array();

    public function register(ViewController $controller) {
        foreach($controller->getRoutingTable() as $route => $handler) {
            $this->routes[$route] = [$controller, $handler];
        }
    }

    public function run(string $url) {
        echo $url.'<br>';
        [$controller, $endpoints] = $this->routes[$url];

        $httpMethod = $controller->request;
        $handler = $endpoints[$httpMethod];

        echo 'request type: '.$httpMethod.', handler: '.$handler.'<br>';
        echo $controller::class.' -> '.$handler.'<br><br>';

        $controller->$handler();
    }
}
