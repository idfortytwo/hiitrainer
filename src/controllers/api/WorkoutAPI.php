<?php

namespace Controllers\API;

use Controllers\Controller;
use HTTP\Responses\JSONResponse;
use Routing\Route;
use DB\Repo\WorkoutRepository;

class WorkoutAPI implements Controller {
    /**
     * @Route(path="/workout/{id}", methods={"GET"})
     */
    public function getWorkout(int $id): JSONResponse {
        $dal = new WorkoutRepository();
        $workout = $dal->getWorkout($id);

        return new JSONResponse([
            'workout' => $workout,
            'exercise' => $workout->getExercises()
        ]);
    }
}
