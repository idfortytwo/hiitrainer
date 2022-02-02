<?php

namespace Controllers\API;

use Controllers\Controller;
use Exception;
use HTTP\Responses\JSONResponse;
use PDOException;
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
     * @Route(path="/workouts/filtered", methods={"POST"})
     */
    public function getFilteredWorkouts(): JSONResponse {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        $title = $input['title'] ?? null;
        $types = $input['types'] ?? null;
        $difficulties = $input['difficulties'] ?? null;
        $focuses = $input['focuses'] ?? null;


        $dal = new WorkoutRepository();
        $workouts = $dal->getFilteredWorkouts($title, $types, $difficulties, $focuses);

        return new JSONResponse([
            'workouts' => $workouts
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
        $stages = $input['stages'];

        try {
            $workoutID = $dal->addWorkout($title, $difficultyID, $focusID, $typeID, $setRestDuration, $setCount, $stages);
            return new JSONResponse([
                'workout_id' => $workoutID
            ]);
        } catch (PDOException $e) {
            return new JSONResponse([
                'error_msg' => $e->getMessage()
            ], 400);
        }
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

    /**
     * @Route(path="/postData", methods={"POST"})
     */
    public function getPostData(): JSONResponse {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
//        var_dump($input);

        return new JSONResponse([
            'inputJson' => $inputJSON
        ]);
    }
}
