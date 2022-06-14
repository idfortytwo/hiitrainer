<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use DB\Models\User;
use DB\Repo\AuthRepository;
use HTTP\Responses\JSONResponse;
use HTTP\Responses\Redirect;
use HTTP\Responses\Response;
use PDOException;
use Routing\Route;

class AuthRenderer extends Renderer {
    /**
     * @Route(path="/register", methods={"GET"})
     */
    public function registerRender(): Response {
        return $this->render('register', [ 'userExists' => 'false' ]);
    }

    /**
     * @Route(path="/register", methods={"POST"})
     */
    public function register(): Response | Redirect {
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
    public function loginRender(): Response {
        return $this->render('login', [
            'emailIncorrect' => 'false',
            'passwordIncorrect' => 'false'
        ]);
    }

    /**
     * @Route(path="/login", methods={"POST"})
     */
    public function login(): Response | Redirect {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $dal = new AuthRepository();
        $dbUser = $dal->getUser($email);

        if ($dbUser == null) {
            return $this->render('login', [
                'emailIncorrect' => 'true',
                'passwordIncorrect' => 'false'
            ]);
        }

        if ($dbUser->getPassword() != $password) {
            return $this->render('login', [
                'emailIncorrect' => 'false',
                'passwordIncorrect' => 'true'
            ]);
        }

        $this->saveUser($dbUser);

        return new Redirect('/workouts');
    }

    /**
     * @Route(path="/logout", methods={"GET"})
     */
    public function logout(): Redirect {
        session_destroy();
        return new Redirect('/workouts');
    }

    private function saveUser(User $user): void {
        $_SESSION['user'] = $user;
    }
}
