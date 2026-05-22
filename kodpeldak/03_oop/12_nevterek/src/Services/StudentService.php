<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    private array $students = [];

    public function register(string $id, string $name): Student
    {
        $student = new Student($id, $name);
        $this->students[$id] = $student;
        return $student;
    }

    public function find(string $id): ?Student
    {
        return $this->students[$id] ?? null;
    }

    public function count(): int
    {
        return count($this->students);
    }
}
