<?php


use Doctrine\Common\Annotations\AnnotationReader;
use Routes\IRoute;


require_once 'IController.php';

abstract class ViewController implements IController {
    public mixed $request;
    private mixed $routingTable = array();

    public function __construct() {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->parseAnnotations();
    }

    protected function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/'. $template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

    public function getRoutingTable() {
        return $this->routingTable;
    }

    public function setRoutingTable(array $routingTable) {
        $this->routingTable = $routingTable;
    }

    private function parseAnnotations() {
        $reflClass = new ReflectionClass(get_class($this));
        $reader = new AnnotationReader();

        foreach ($reflClass->getMethods() as $controllerMethod) {
            $annotations = $reader->getMethodAnnotations($controllerMethod);
            foreach ($annotations as $route) {
                if ($route instanceof IRoute) {
                    $this->registerEndpoint($route, $controllerMethod->name);
                }
            }
        }
    }

    private function registerEndpoint(IRoute $route, $endpoint) {
        $path = substr($route->getPath(), 1);
        $methods = $route->getMethods();

        $this->updateRoutingTable($path, $methods, $endpoint);
    }

    private function updateRoutingTable($path, $methods, $endpoint) {
        $routingTable = $this->getRoutingTable();

        $endpoints = $routingTable[$path] ?? array();
        foreach ($methods as $method)
            $endpoints[$method] = $endpoint;
        $routingTable[$path] = $endpoints;

        $this->setRoutingTable($routingTable);
    }
}
