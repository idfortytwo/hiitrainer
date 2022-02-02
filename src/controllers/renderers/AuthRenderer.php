<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use DB\Repo\AuthRepository;
use HTTP\Responses\Redirect;
use PDOException;
use Routing\Route;

class AuthRenderer extends Renderer {
    /**
     * @Route(path="/register", methods={"GET"})
     */
    public function registerRender() {
        return $this->render('register', [ 'userExists' => 'false' ]);
    }

    /**
     * @Route(path="/register", methods={"POST"})
     */
    public function register() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $dal = new AuthRepository();
        try {
            $newUserID = $dal->addUser($email, $password);
        } catch (PDOException $e) {
            return $this->render('register', ['userExists' => 'true']);
        }

        return new Redirect('/workouts');
    }
}
