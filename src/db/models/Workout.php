<?php

namespace DB\Models;

use JsonSerializable;

class Workout implements JsonSerializable {
    private int $id;
    private string $title;
    private int $setCount;
    private int $setRestDuration;
    private array $stages;

    public function __construct(int $id, string $title, int $setCount, int $setRestDuration, array $stages = []) {
        $this->id = $id;
        $this->title = $title;
        $this->setRestDuration = $setRestDuration;
        $this->setCount = $setCount;
        $this->stages = $stages;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }
    public function getSetCount(): int {
        return $this->setCount;
    }

    public function getSetRestDuration(): int {
        return $this->setRestDuration;
    }

    public function getStages(): array {
        return $this->stages;
    }

    public function __toString(): string {
        return "Workout(id: {$this->id}, title: '{$this->title}', 
                setCount: {$this->setCount}, setRestDuration: {$this->setRestDuration})";
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'setCount' => $this->setCount,
            'setRestDuration' => $this->setRestDuration,
            'stages' => $this->stages
        ];
    }
}
