<?php

require_once 'ViewController.php';

require_once 'src/routing/Route.php'; use Routes\Route;

class DefaultController extends ViewController {
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function root() {
        echo 'at root';
    }

    /**
     * @Route(path="/", methods={"POST"})
     */
    public function rootPost() {
        echo 'posting at root';
    }

    /**
     * @Route(path="/hello", methods={"GET", "POST"})
     */
    public function hello() {
        echo 'HELLO';
    }
}
