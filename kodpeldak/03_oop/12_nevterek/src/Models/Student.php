<?php

namespace App\Models;

class Student
{
    public function __construct(
        private string $id,
        private string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return "[{$this->id}] {$this->name}";
    }
}
