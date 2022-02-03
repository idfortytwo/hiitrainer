<?php

namespace Controllers\API;

use Controllers\Controller;
use DB\Models\User;
use Exception;
use HTTP\Responses\JSONResponse;
use HTTP\Responses\Response;
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
    public function getFilteredWorkouts(bool $favourite = false): JSONResponse {
        $inputJSON = file_get_contents('php://input');

        $input = json_decode($inputJSON, TRUE);
        $title = $input['title'] ?? null;
        $types = $input['types'] ?? null;
        $difficulties = $input['difficulties'] ?? null;
        $focuses = $input['focuses'] ?? null;

        $dal = new WorkoutRepository();

        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $workouts = $dal->getFilteredWorkouts($favourite, $user->getId(), $title, $types, $difficulties, $focuses);
            $this->setFavouriteFlags($workouts);
        } else {
            $workouts = $dal->getFilteredWorkouts($title, $types, $difficulties, $focuses);
        }

        return new JSONResponse([
            'workouts' => $workouts,
            'user' => $user
        ]);
    }

    protected function setFavouriteFlags(array $workouts) {
        $dal = new WorkoutRepository();

        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $favWorkoutIDs = $dal->getFavouriteWorkoutIDs($user->getId());
            foreach ($workouts as $workout) {

                $workoutID = $workout->getId();
                if (in_array($workoutID, $favWorkoutIDs)) {
                    $workout->setIsFavourite(true);
                }
            }
        }
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

        $this->setFavouriteFlags($workouts);

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

    /**
     * @Route(path="/like/{workoutID}", methods={"POST"})
     */
    public function likeWorkout(int $workoutID): Response {
        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $dal = new WorkoutRepository();
            $dal->likeWorkout($user->getId(), $workoutID);
            return new JSONResponse('Successfully liked');
        } else {
            return new Response('', 401);
        }
    }

    /**
     * @Route(path="/unlike/{workoutID}", methods={"POST"})
     */
    public function unlikeWorkout(int $workoutID): Response {
        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $dal = new WorkoutRepository();
            $dal->unlikeWorkout($user->getId(), $workoutID);
            return new JSONResponse('Successfully unliked');
        } else {
            return new Response('', 401);
        }
    }
}
