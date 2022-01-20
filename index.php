<?php

set_include_path('src' . PATH_SEPARATOR . 'libs');
spl_autoload_extensions('.php, .inc');
spl_autoload_register();


require_once 'src/db/repo/ExerciseRepository.php';
require_once 'src/routing/Routing.php';


$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$router = new Routing();
$router->setup();
$router->run($path);
