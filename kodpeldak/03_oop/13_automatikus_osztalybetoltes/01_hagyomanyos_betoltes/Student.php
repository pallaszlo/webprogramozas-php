<?php

// =============================================================
// 3.52. Hagyományos osztálybetöltés (Student.php)
// =============================================================

class Student
{
    public function __construct(
        private string $name,
        private int $age
    ) {}

    public function getInfo(): string
    {
        return "Hallgató: {$this->name}, kor: {$this->age}";
    }
}
