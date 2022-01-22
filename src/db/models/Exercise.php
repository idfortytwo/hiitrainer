<?php

namespace DB\Models;

class Exercise {
    private int $id;
    private string $name;
    private string $filename;

    public function __construct() {}

    public static function construct(int $id, string $name, string $filename): Exercise {
        $exercise = new Exercise();
        $exercise->id = $id;
        $exercise->name = $name;
        $exercise->filename = $filename;
        return $exercise;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function __toString(): string {
        return "Exercise(id: {$this->id}, name: {$this->name}, filename: {$this->filename})";
    }
}
