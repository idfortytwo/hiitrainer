<?php

namespace DB\Models;

use JsonSerializable;

class Stage implements JsonSerializable {
    private Exercise $exercise;
    private int $order;
    private string $type;
    private mixed $value;

    public function __construct(Exercise $exercise, int $order, string $type, mixed $value) {
        $this->exercise = $exercise;
        $this->order = $order;
        $this->type = $type;
        $this->value = $value;
    }

    public function getExercise(): Exercise {
        return $this->exercise;
    }

    public function getOrder(): int {
        return $this->order;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getValue(): mixed {
        return $this->value;
    }

    public function jsonSerialize(): array {
        return [
            'exercise' => $this->exercise,
            'order' => $this->order,
            'type' => $this->type,
            'value' => $this->value
        ];
    }
}
