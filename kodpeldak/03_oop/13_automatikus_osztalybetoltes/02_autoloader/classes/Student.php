<?php

// A Student osztály (azonos a 3.54. kódpélda Student.php fájljával)

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
