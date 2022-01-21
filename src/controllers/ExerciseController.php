<?php

namespace Controllers;

use Routing\Route;
use DB\Repo\ExerciseRepository;

class ExerciseController extends ViewController {
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
