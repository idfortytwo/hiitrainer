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
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);

        $dal = new WorkoutRepository();

        $title = $input['title'];
        $difficultyID = $dal->getWorkoutDifficultyID($input['difficulty']);
        $typeID = $dal->getWorkoutTypeID($input['type']);
        $focusID = $dal->getWorkoutFocusID($input['focus']);
        $setRestDuration = $input['set_rest_duration'];
        $setCount = $input['set_count'];

        $workoutID = $dal->addWorkout($title, $difficultyID, $focusID, $typeID, $setRestDuration, $setCount);

        $stages = $input['stages'];
        $dal->addStages($stages, $workoutID);

        return new JSONResponse([
            'workout_id' => $workoutID
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
