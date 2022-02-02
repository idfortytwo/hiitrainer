<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use DB\Models\User;
use DB\Repo\AuthRepository;
use HTTP\Responses\JSONResponse;
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
            $newUser = $dal->addUser($email, $password);
            $this->saveUser($newUser);
        } catch (PDOException $e) {
            return $this->render('register', ['userExists' => 'true']);
        }

        return new Redirect('/workouts');
    }

    /**
     * @Route(path="/login", methods={"GET"})
     */
    public function loginRender() {
        return $this->render('login', [
            'emailIncorrect' => 'false',
            'passwordIncorrect' => 'false'
        ]);
    }

    /**
     * @Route(path="/login", methods={"POST"})
     */
    public function login() {
        $email = $_POST['email'];

        $dal = new AuthRepository();
        $user = $dal->getUser($email);

        if ($user == null) {
            return $this->render('login', [
                'emailIncorrect' => 'true',
                'passwordIncorrect' => 'false'
            ]);
        }

        $currentUser = $_SESSION['user'];
        if ($user->getPassword() != $currentUser->getPassword()) {
            return $this->render('login', [
                'emailIncorrect' => 'false',
                'passwordIncorrect' => 'true'
            ]);
        }

        return new Redirect('/workouts');
    }

    private function saveUser(User $user) {
        $_SESSION['user'] = $user;
    }
}
