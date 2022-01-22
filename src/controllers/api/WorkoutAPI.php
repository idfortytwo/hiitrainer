<?php

namespace Controllers\API;

use Controllers\Controller;
use Routing\Route;
use DB\Repo\WorkoutRepository;

class WorkoutAPI implements Controller {
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
