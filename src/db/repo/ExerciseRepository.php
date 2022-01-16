<?php

require_once 'src/db/repo/Repository.php';
require_once 'src/db/models/Exercise.php';

class ExerciseRepository extends Repository {
    /**
     * @return array<int, Exercise>
     */
    public function getExercises() : array {
        $stmt = $this->getQuery("SELECT * FROM exercise");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Exercise');
        return $stmt->fetchAll();
    }

    /**
     * @param int
     * @return Exercise
     */
    public function getExercise(int $id) : Exercise {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("SELECT * FROM exercise WHERE id = :id;");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Exercise');
        return $stmt->fetch();
    }
}
