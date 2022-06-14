<?php

namespace Controllers\Renderers;

use Controllers\Renderer;
use DB\Models\Stage;
use DB\Models\User;
use DB\Repo\ExerciseRepository;
use DB\Repo\WorkoutRepository;
use HTTP\Responses\JSONResponse;
use HTTP\Responses\Response;
use Routing\Route;

class WorkoutRenderer extends Renderer {
    /**
     * @Route(path="/workouts", methods={"GET"})
     */
    public function workouts(bool $favourite = false): Response {
        $dal = new WorkoutRepository();

        /* @var User $user */
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $workouts = $dal->getWorkouts($favourite, $user->getId());
        } else {
            $workouts = $dal->getWorkouts();
        }

        $this->setFavouriteFlags($workouts);

        return $this->render('workouts', ['workouts' => $workouts]);
    }

    /**
     * @Route(path="/workouts/{id}", methods={"GET"})
     */
    public function workout(int $id): Response {
        $dal = new WorkoutRepository();
        $workout = $dal->getWorkout($id);

        return $this->render('workout', ['workout' => $workout]);
    }

    /**
     * @Route(path="/workouts/creator", methods={"GET"})
     */
    public function addWorkout(): Response {
        $dal = new ExerciseRepository();
        $exercises = $dal->getExercises();

        return $this->render('add-workout', [
            'exercises' => $exercises
        ]);
    }

    protected function setFavouriteFlags(array $workouts): void {
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
}

