<?php

namespace Routing;

use Controllers\Controller;
use HTTP\Requests\Request;
use HTTP\Responses\IResponse;
use HTTP\Responses\NotFoundResponse;
use Routing\Endpoints\Endpoint;

class Router {
    public array $routes = array();

    public function register(Controller $controller) {
        $inspector = new RouteInspector($controller);
        foreach($inspector->getRoutingMap() as $urlRegex => $endpoint) {
            $this->routes[$urlRegex] = $endpoint;
        }
    }

    public function run(Request $request) : IResponse {
        [$path, $queryArgs] = $this->parseUrl($request->getUrl());

        foreach ($this->routes as $pathRegex => $requestMethodsMap) {
            $matches = preg_match($pathRegex, $path, $matchesArr);
            if ($matches) {
                /** @var Endpoint $endpoint */
                $pathArgs = array_filter($matchesArr, "is_string", ARRAY_FILTER_USE_KEY);
                $args = array_merge($pathArgs, $queryArgs);

                $endpoint = $requestMethodsMap[$request->getMethod()];
                return $endpoint->handle($args);
            }
        }
        return new NotFoundResponse();
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
