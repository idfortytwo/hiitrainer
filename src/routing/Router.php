<?php

namespace Routing;

use Controllers\Controller;

class Router {
    public array $routes = array();

    public function register(Controller $controller) {
        $inspector = new RouteInspector($controller);
        foreach($inspector->getRoutingMap() as $urlRegex => $endpoint) {
            $this->routes[$urlRegex] = $endpoint;
        }
    }

    public function run(string $url, string $requestMethod) {
        [$path, $queryArgs] = $this->parseUrl($url);

        foreach ($this->routes as $pathRegex => $requestMethodsMap) {
            $matches = preg_match($pathRegex, $path, $matchesArr);
            if ($matches) {
                $endpoint = $requestMethodsMap[$requestMethod];
                echo $requestMethod.' '.$endpoint->getController()::class.' -> '.$endpoint->getMethodName().'<br><br>';

                $pathArgs = array_filter($matchesArr, "is_string", ARRAY_FILTER_USE_KEY);
                $args = array_merge($pathArgs, $queryArgs);

                $endpoint->handle($args);
            }
        }
    }

    private function parseUrl(string $url) : array {
        $urlParts = parse_url($url);
        $path = $urlParts['path'];
        $queryArgs = array();
        if (array_key_exists('query', $urlParts)) {
            parse_str($urlParts['query'], $queryArgs);
        }

        return [$path, $queryArgs];
    }
}
