<?php

set_include_path('src' . PATH_SEPARATOR . 'libs');
spl_autoload_extensions('.php, .inc');
spl_autoload_register();

use HTTP\Requests\Request;
use Routing\Routing;


$router = new Routing();
$router->setup();

$url = trim($_SERVER['REQUEST_URI'], '/');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$request = new Request($url, $requestMethod);

$response = $router->run($request);
$response->send();
