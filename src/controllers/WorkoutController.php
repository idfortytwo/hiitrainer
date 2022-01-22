<?php

namespace Controllers;

use Routing\Route;
use DB\Repo\WorkoutRepository;

class WorkoutController extends ViewController {
    /**
     * @Route(path="/workout/{id}", methods={"GET"})
     */
    public function getWorkout(int $id) {
        $dal = new WorkoutRepository();
        $workout = $dal->getWorkout($id);

        echo "ID: {$id}<br>";
        var_dump($workout->getExercises());
    }
}
