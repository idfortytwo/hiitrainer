<?php

require_once 'ViewController.php';

require_once 'src/routing/Route.php'; use Routes\Route;

class DefaultController extends ViewController {
    /**
     * @Route(path="/", method="GET")
     */
    public function root() {
        echo 'at root';
    }

    /**
     * @Route(path="/", method="POST")
     */
    public function rootPost() {
        echo 'posting at root';
    }

    /**
     * @Route(path="/hello", method="GET")
     */
    public function hello() {
        echo 'HELLO';
    }
}
