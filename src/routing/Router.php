<?php

namespace Routing;

use Controllers\IController;
use Routing\Endpoints\Endpoint;

class Router {
    public array $routes = array();

    public function register(IController $controller) {
        $inspector = new RouteInspector($controller);
        foreach($inspector->getRoutingMap() as $url => $endpoint) {
            $this->routes[$url] = $endpoint;
        }
    }

    public function run(string $url, string $requestMethod) {
        $urlParts = parse_url($url);
        $path = $urlParts['path'];
        $args = array();
        if (array_key_exists('query', $urlParts)) {
            parse_str($urlParts['query'], $args);
        }

        /** @var Endpoint $endpoint */
        $endpoint = $this->routes[$path][$requestMethod];

        echo $requestMethod.' '.$endpoint->getController()::class.' -> '.$endpoint->getMethodName().'<br><br>';
        $endpoint->handle($args);
    }
}
