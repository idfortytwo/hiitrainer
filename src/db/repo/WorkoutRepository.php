<?php

namespace DB\Repo;

use DB\Models\Stage;
use PDO;

use DB\Models\Exercise;
use DB\Models\Workout;

class WorkoutRepository extends Repository {
    public function getWorkouts() : array {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select wkt.id, wkt.title, wt.type, wd.difficulty, wf.focus, wkt.set_count, wkt.set_rest_duration, wkt.image
        from workout as wkt
             join workout_difficulty wd on wd.id = wkt.difficulty_id
             join workout_type wt on wt.id = wkt.focus_id
             join workout_focus wf on wf.id = wkt.focus_id
        ");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();

        $workouts = array();
        foreach ($rs as $r) {
            $workout = new Workout($r['id'], $r['title'], $r['type'], $r['difficulty'], $r['focus'], $r['set_count'], $r['set_rest_duration'], $r['image']);
            $workouts[] = $workout;
        };
        return $workouts;
    }

    /**
     * @param int $id
     * @return Workout|null
     */
    public function getWorkout(int $id) : Workout|null {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select wkt.id, wkt.title, wt.type, wd.difficulty, wf.focus, wkt.set_count, set_rest_duration, wkt.image, 
               e.name, st.type stage_type, sem.stage_data, sem.\"order\", rest_duration, filename
        from workout wkt
             join workout_type wt on wt.id = wkt.type_id
             join workout_difficulty wd on wd.id = wkt.difficulty_id
             join workout_focus wf on wf.id = wkt.focus_id
             join exercise_workout_map sem on wkt.id = sem.wkt_id
             join stage_type st on st.id = sem.stage_type_id
             join exercise e on sem.exr_id = e.id
        where wkt.id = :id
        order by sem.\"order\";
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();

        $stages = array();
        foreach ($rs as $record) {
            $exercise = Exercise::construct($record['id'], $record['name'], $record['filename']);
            $stage = new Stage($exercise, $record['order'], $record['stage_type'], $record['stage_data']);
            $stages[] = $stage;
        }

        $fr = $rs[0];
        return new Workout($fr['id'], $fr['title'], $fr['type'], $fr['difficulty'], $fr['focus'],
            $fr['set_count'], $fr['set_rest_duration'], $fr['image'], $stages);
    }
}
