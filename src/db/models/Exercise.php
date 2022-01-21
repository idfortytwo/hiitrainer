<?php

namespace DB\Models;

class Exercise {
    private int $id;
    private string $name;
    private string $filename;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function setFilename(string $filename): void {
        $this->filename = $filename;
    }

    public function __toString(): string {
        return 'Exercise(' . $this->id . ', ' . $this->name . ', ' . $this->filename . ')';
    }
}
