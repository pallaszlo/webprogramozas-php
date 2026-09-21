<?php

// =============================================================
// 3.11. Traitek
// =============================================================


// --- 3.45. Trait és öröklődés együttes használata ------------
trait Gradeable
{
    private array $grades = [];

    public function addGrade(string $subject, int $grade): void
    {
        $this->grades[$subject] = $grade;
    }

    public function getAverage(): float
    {
        return empty($this->grades)
            ? 0.0
            : array_sum($this->grades) / count($this->grades);
    }
}

class Person
{
    public function __construct(public string $name) {}
}

class Student extends Person
{
    use Gradeable;
}

$student = new Student("Varga Anna");

$student->addGrade("Webprogramozás", 8);
$student->addGrade("Adatbázisok", 9);

echo $student->getAverage(); // 8.5
