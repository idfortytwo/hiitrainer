<?php

namespace DB\Repo;

use PDO;

use DB\Models\Exercise;
use DB\Models\Workout;

class WorkoutRepository extends Repository {
    /**
//     * @return array<int, Workout>
     * @return mixed|Workout
     */
    public function getWorkout(int $id) : mixed {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
            select wkt.id, wkt.title, set_count, set_rest_duration, e.name, st.type stage_type, sem.stage_data, rest_duration, filename 
                from workout wkt
            join set_workout_map swm on wkt.id = swm.wrkt_id
            join set_exercise_map sem on swm.set_id = sem.set_id
            join stage_type st on st.id = sem.stage_type_id
            join exercise e on sem.exr_id = e.id
            where wkt.id = :id
            order by sem.\"order\";");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();

        $exercises = array();
        foreach ($rs as $record) {
            $exercise = Exercise::construct($record['id'], $record['name'], $record['filename']);
            $exercises[] = [
                'exercise' => $exercise,
                'stageType' => $record['stage_type'],
                'stageData' => $record['stage_data']
            ];
        }

        $fr = $rs[0];
        return new Workout($fr['id'], $fr['title'], $fr['set_count'], $fr['set_rest_duration'], $exercises);
    }
}
