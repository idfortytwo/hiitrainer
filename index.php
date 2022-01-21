<?php

set_include_path('src' . PATH_SEPARATOR . 'libs');
spl_autoload_extensions('.php, .inc');
spl_autoload_register();

use Routing\Routing;

$url = trim($_SERVER['REQUEST_URI'], '/');
$url = parse_url($url, PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new Routing();
$router->setup();
$router->run($url, $requestMethod);
