<?php

require_once 'src/db/repo/ExerciseRepository.php';

require_once 'src/routing/Route.php'; use Routes\Route;

class ExerciseController extends ViewController {
    /**
     * @Route(path="/exercises", method="GET")
     */
    public function getAll() {
        $dal = new ExerciseRepository();
        foreach($dal->getExercises() as $exercise) {
            echo '<img src="public/images/' . $exercise->getFilename() .'" alt=""><br>';
        }
    }
}
