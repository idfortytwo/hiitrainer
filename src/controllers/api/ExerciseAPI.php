<?php

namespace Controllers\API;

use Controllers\Controller;
use Routing\Route;
use DB\Repo\ExerciseRepository;

class ExerciseAPI implements Controller {
    /**
     * @Route(path="/exercises", methods={"GET"})
     */
    public function getAll() {
        $dal = new ExerciseRepository();
        foreach($dal->getExercises() as $exercise) {
            echo '<img src="public/images/' . $exercise->getFilename() .'" alt=""><br>';
        }
    }
}
