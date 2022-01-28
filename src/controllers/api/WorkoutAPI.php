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
            'workout' => $workout
        ]);
    }


    /**
     * @Route(path="/workout", methods={"POST"})
     */
    public function addWorkout(): JSONResponse {
        $dal = new WorkoutRepository();
//        $workout = $dal->getWorkout();

        return new JSONResponse([
//            'workout' => $workout
        ]);
    }

    /**
     * @Route(path="/api/workouts", methods={"GET"})
     */
    public function apiWorkouts() : JSONResponse{
        $dal = new WorkoutRepository();
        $workouts = $dal->getWorkouts();

        return new JSONResponse(['workouts' => $workouts]);
    }

    /**
     * @Route(path="/api/workouts/{id}", methods={"GET"})
     */
    public function apiWorkout(int $id) : JSONResponse {
        $dal = new WorkoutRepository();
        $workout = $dal->getWorkout($id);

        return new JSONResponse(['workout' => $workout]);
    }
}
