<?php

namespace Controllers\API;

use Controllers\Controller;
use HTTP\Responses\JSONResponse;
use Routing\Route;
use DB\Repo\ExerciseRepository;

class ExerciseAPI implements Controller {
    /**
     * @Route(path="/exercises", methods={"GET"})
     */
    public function getAll(): JSONResponse {
        $dal = new ExerciseRepository();
        return new JSONResponse([
            'exercises' => $dal->getExercises()
        ]);
    }
}
