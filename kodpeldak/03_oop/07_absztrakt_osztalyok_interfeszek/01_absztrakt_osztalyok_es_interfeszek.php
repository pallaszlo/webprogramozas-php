<?php

// =============================================================
// 3.7. Absztrakt osztályok és interfészek
// =============================================================


// --- 3.27. Absztrakt osztály példa ---------------------------
abstract class Shape
{
    protected string $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    abstract public function getArea(): float;

    public function getColor(): string
    {
        return $this->color;
    }
}

class Square extends Shape
{
    private float $side;

    public function __construct(string $color, float $side)
    {
        parent::__construct($color);
        $this->side = $side;
    }

    public function getArea(): float
    {
        return $this->side * $this->side;
    }
}

$square = new Square("piros", 5);
echo "Terület: " . $square->getArea() . ", Szín: " . $square->getColor();
// Kimenet: Terület: 25, Szín: piros


// --- 3.28. Egyszerű interfész példa --------------------------
interface Drawable
{
    public function draw(): string;
}

class Circle implements Drawable
{
    private int $radius;

    public function __construct(int $radius)
    {
        $this->radius = $radius;
    }

    public function draw(): string
    {
        return "Kör rajzolása, sugár: {$this->radius}";
    }
}

$circle = new Circle(10);
echo $circle->draw();  // Kimenet: Kör rajzolása, sugár: 10


// --- 3.29. Interfész példa a Student osztály esetén ----------
interface Enrollable
{
    public function enroll(string $course): void;
    public function getEnrolledCourses(): array;
}

class Student implements Enrollable
{
    private string $id;
    private string $name;
    private array $courses = [];

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function enroll(string $course): void
    {
        $this->courses[] = $course;
    }

    public function getEnrolledCourses(): array
    {
        return $this->courses;
    }
}

$student = new Student("S12345", "Molnár Eszter");
$student->enroll("Webprogramozás");
$student->enroll("Adatbázisok");

echo "Felvett kurzusok: " . implode(", ", $student->getEnrolledCourses());
// Kimenet: Felvett kurzusok: Webprogramozás, Adatbázisok
