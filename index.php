<?php

set_include_path('src' . PATH_SEPARATOR . 'libs');
spl_autoload_extensions('.php, .inc');
spl_autoload_register();


require_once 'src/db/repo/ExerciseRepository.php';
require_once 'src/routing/Routing.php';


$url = trim($_SERVER['REQUEST_URI'], '/');
$url = parse_url($url, PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new Routing();
$router->setup();
$router->run($url, $requestMethod);
