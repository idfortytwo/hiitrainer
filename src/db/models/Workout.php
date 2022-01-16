<?php

class Workout {
    private int $id;
    private string $title;
    private int $setRestDuration;

    public function __construct(int $id, string $title, int $setRestDuration) {
        $this->id = $id;
        $this->title = $title;
        $this->setRestDuration = $setRestDuration;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getSetRestDuration(): int {
        return $this->setRestDuration;
    }

    public function setSetRestDuration(int $setRestDuration): void {
        $this->setRestDuration = $setRestDuration;
    }

}
