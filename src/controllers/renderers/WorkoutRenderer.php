<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use DB\Models\Stage;
use DB\Repo\WorkoutRepository;
use HTTP\Responses\JSONResponse;
use Routing\Route;

class WorkoutRenderer extends Renderer {
    /**
     * @Route(path="/workouts", methods={"GET"})
     */
    public function workouts() {
        $dal = new WorkoutRepository();
        $workouts = $dal->getWorkouts();

        return $this->render('workouts', ['workouts' => $workouts]);
    }

    /**
     * @Route(path="/workouts/{id}", methods={"GET"})
     */
    public function workout(int $id) {
        $dal = new WorkoutRepository();
        $workout = $dal->getWorkout($id);

        return $this->render('workout', ['workout' => $workout]);
    }
}

