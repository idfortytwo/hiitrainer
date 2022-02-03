<?php

namespace Controllers;

use DB\Models\User;
use HTTP\Responses\Response;

abstract class Renderer implements Controller {
    protected function render(string $template = null, array $variables = []): Response {
        $templatePath = 'public/views/'. $template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)){
            $variables['renderer'] = $this;
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        return new Response($output);
    }

    public function getHeaderLinks() {
        echo '<a class="nav-item" href="/workouts/">Workouts</a>';

        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            switch ($user->getType()) {
                case 'user':
                    echo '<a class="nav-item" href="/workouts/">Favourites</a>';
                    break;
                case 'admin':
                    echo '<a class="nav-item" href="/workouts/">Favourites</a>';
                    echo '<a class="nav-item" href="/workouts/creator">Creator</a>';
                    break;
            }
        }
    }

    public function getAuthButtons() {
        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            echo
            '<a class="nav-item" href="/logout">
                <i class="fas fa-sign-out-alt nav-item"></i>
            </a>';
        } else {
            echo
            '<a class="nav-item" href="/login">
                <i class="fa fa-sign-in nav-item" aria-hidden="true"></i>
            </a>';
            echo
            '<a class="nav-item" href="/register">
                <i class="fa fa-user-plus nav-item" aria-hidden="true"></i>
            </a>';
        }
    }
}
