<?php

namespace DB\Models;

use JsonSerializable;

class Workout implements JsonSerializable {
    private int $id;
    private string $title;
    private string $type;
    private string $difficulty;
    private string $focus;
    private int $setCount;
    private int $setRestDuration;
    private string $image;

    private array $stages;

    public function __construct(int $id, string $title, string $type, string $difficulty, string $focus,
                                int $setCount, int $setRestDuration, string $image, array $stages = []) {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->difficulty = $difficulty;
        $this->focus = $focus;
        $this->setRestDuration = $setRestDuration;
        $this->setCount = $setCount;
        $this->image = $image;
        $this->stages = $stages;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getDifficulty(): string {
        return $this->difficulty;
    }

    public function getFocus(): string {
        return $this->focus;
    }

    public function getSetCount(): int {
        return $this->setCount;
    }

    public function getSetRestDuration(): int {
        return $this->setRestDuration;
    }

    public function getImage(): string {
        return $this->image;
    }

    /**
     * @return array<Stage>
     */
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
            'type' => $this->type,
            'difficulty' => $this->difficulty,
            'focus' => $this->focus,
            'setCount' => $this->setCount,
            'setRestDuration' => $this->setRestDuration,
            'stages' => $this->stages,
            'image' => $this->image
        ];
    }
}
