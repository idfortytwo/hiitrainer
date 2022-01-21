<?php

class Router {
    public array $routes = array();

    public function register(IController $controller) {
        $inspector = new RouteInspector($controller);
        foreach($inspector->getRoutingMap() as $url => $endpoint) {
            $this->routes[$url] = $endpoint;
        }
    }

    public function run(string $url, string $requestMethod) {
        $endpoint = $this->routes[$url][$requestMethod];
        echo $requestMethod.' '.$endpoint->getController()::class.' -> '.$endpoint->getMethodName().'<br><br>';
        $endpoint->handle();
    }
}
