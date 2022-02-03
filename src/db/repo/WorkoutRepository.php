<?php

namespace DB\Repo;

use DB\Models\Stage;
use Exception;
use PDO;

use DB\Models\Exercise;
use DB\Models\Workout;
use PDOException;

class WorkoutRepository extends Repository {
    /**
     * @return array<Workout>
     */
    public function getWorkouts() : array {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select wkt.id, wkt.title, wt.type, wd.difficulty, wf.focus, wkt.set_count, wkt.set_rest_duration, wt.image
        from workout as wkt
             join workout_difficulty wd on wd.id = wkt.difficulty_id
             join workout_type wt on wt.id = wkt.focus_id
             join workout_focus wf on wf.id = wkt.focus_id
        ");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();

        return $this->parseWorkoutsResultSet($rs);
    }

    /**
     * @param string|null $title
     * @param array|null $types
     * @param array|null $difficulties
     * @param array|null $focuses
     * @return array<Workout>
     */
    public function getFilteredWorkouts(string $title=null,
                                        array  $types=null,
                                        array  $difficulties=null,
                                        array  $focuses=null): array {
        $stmt = $this->database->connect();
        $query = "
        select wkt.id, wkt.title, wt.type, wd.difficulty, wf.focus, wkt.set_count, wkt.set_rest_duration, wt.image
        from workout as wkt
             join workout_difficulty wd on wd.id = wkt.difficulty_id
             join workout_type wt on wt.id = wkt.focus_id
             join workout_focus wf on wf.id = wkt.focus_id
        where 
        ";

        $boundParams = array();
        $paramCount = 0;
        $filterCount = 0;

        if ($title != null) {
            $query .= "lower(title) like ?";
            $boundParams[] = [1, '%'.$title.'%', PDO::PARAM_STR];
            $filterCount++;
            $paramCount++;
        }

        if ($types != null) {
            $typesQuery = implode(',', array_fill(0, count($types), '?'));

            if ($filterCount > 0)
                $query .= ' and ';
            $query .= 'type in (' . $typesQuery . ')';

            foreach ($types as $type) {
                $boundParams[] = [($paramCount+1), $type, PDO::PARAM_STR];
                $paramCount++;
            }
            $filterCount++;
        }

        if ($difficulties != null) {
            $difficultiesQuery = implode(',', array_fill(0, count($difficulties), '?'));

            if ($filterCount > 0)
                $query .= ' and ';
            $query .= 'difficulty in (' . $difficultiesQuery . ')';

            foreach ($difficulties as $difficulty) {
                $boundParams[] = [($paramCount+1), $difficulty, PDO::PARAM_STR];
                $paramCount++;
            }
            $filterCount++;
        }

        if ($focuses != null) {
            $focusesQuery = implode(',', array_fill(0, count($focuses), '?'));

            if ($filterCount > 0)
                $query .= ' and ';
            $query .= 'focus in (' . $focusesQuery . ')';

            foreach ($focuses as $focus) {
                $boundParams[] = [($paramCount+1), $focus];
                $paramCount++;
            }
        }

        $query .= ';';

        $stmt = $stmt->prepare($query);
        foreach ($boundParams as [$param, $value]) {
            $stmt->bindValue($param, $value);
        }
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();

        return $this->parseWorkoutsResultSet($rs);
    }

    /**
     * @param $rs
     * @return array<Workout>
     */
    protected function parseWorkoutsResultSet($rs): array {
        $workouts = array();
        foreach ($rs as $r) {
            $workout = new Workout($r['id'], $r['title'], $r['type'], $r['difficulty'], $r['focus'], $r['set_count'], $r['set_rest_duration'], $r['image']);
            $workouts[] = $workout;
        }
        return $workouts;
    }

    /**
     * @param int $id
     * @return Workout|null
     */
    public function getWorkout(int $id) : Workout|null {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select wkt.id, wkt.title, wt.type, wd.difficulty, wf.focus, wkt.set_count, set_rest_duration, wt.image, 
               e.name, st.type stage_type, sem.stage_data, sem.\"order\", filename
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

    public function getWorkoutDifficultyID(string $difficulty) : int {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select id 
        from postgres.public.workout_difficulty
        where difficulty = :difficulty 
        ");
        $stmt->bindValue(':difficulty', $difficulty);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch()['id'];
    }

    public function getWorkoutTypeID(string $type) : int {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select id 
        from postgres.public.workout_type
        where type = :type 
        ");
        $stmt->bindValue(':type', $type);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch()['id'];
    }

    public function getWorkoutFocusID(string $focus) : int {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        select id 
        from postgres.public.workout_focus
        where focus = :focus 
        ");
        $stmt->bindValue(':focus', $focus);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch()['id'];
    }

    public function addWorkout(string $title, int $difficultyID, int $focusID, int $typeID,
                               int $setRestDuration, int $setCount, array $stages) : int {
        $conn = $this->database->connect();
        $conn->beginTransaction();

        try {
            $stmt = $conn->prepare("
        insert into workout (title, difficulty_id, focus_id, type_id, set_rest_duration, set_count) 
        values (:title, :difficulty_id, :focus_id, :type_id, :set_rest_duration, :set_count)
        returning id; 
        ");

            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':difficulty_id', $difficultyID);
            $stmt->bindValue(':focus_id', $focusID);
            $stmt->bindValue(':type_id', $typeID);
            $stmt->bindValue(':set_rest_duration', $setRestDuration);
            $stmt->bindValue(':set_count', $setCount);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $workoutID = $stmt->fetch()['id'];

            $query = 'insert into exercise_workout_map (wkt_id, exr_id, "order", stage_type_id, stage_data) values';

            for ($i = 0; $i < count($stages); $i++) {
                $query .= "(:wkt_id_{$i}, :exr_id_{$i}, :order_{$i}, :stage_type_id_{$i}, :stage_data_{$i}), ";
            }
            $query = rtrim($query, ', ');
            $query .= ';';
            $stmt = $conn->prepare($query);

            $i = 0;
            foreach ($stages as $order => $stage) {
                $stmt->bindValue(":wkt_id_$i", $workoutID);
                $stmt->bindValue(":exr_id_{$i}", $stage['exercise_id']);
                $stmt->bindValue(":order_{$i}", $order);
                $stmt->bindValue(":stage_type_id_{$i}", $stage['stage_type_id']);
                $stmt->bindValue(":stage_data_{$i}", $stage['stage_data']);
                $i++;
            }

            $stmt->execute();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw $e;
        }

        $conn->commit();

        return $workoutID;
    }

    public function getFavouriteWorkoutIDs(int $userID) : array {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
            SELECT workout_id 
            FROM user_favourite_workout_map
            WHERE user_id = :user_id;
        ");
        $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetchAll();
        $workoutIDs = [];
        foreach ($rs as $record) {
            $workoutIDs[] = $record['workout_id'];
        }
        return $workoutIDs;
    }

    public function likeWorkout(int $userID, int $workoutID) : void {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
            INSERT INTO user_favourite_workout_map (user_id, workout_id) 
            VALUES (:user_id, :workout_id);
        ");
        $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindValue(':workout_id', $workoutID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function unlikeWorkout(int $userID, int $workoutID) : void {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
            DELETE FROM user_favourite_workout_map
            WHERE user_id = :user_id AND workout_id = :workout_id;
        ");
        $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindValue(':workout_id', $workoutID, PDO::PARAM_INT);
        $stmt->execute();
    }
}
