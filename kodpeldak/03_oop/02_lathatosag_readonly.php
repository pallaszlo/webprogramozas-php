<?php

// ============================================================
// Láthatósági módosítók, getter/setter, readonly
// Kapcsolódó fejezet: 3.2. Tulajdonságok, metódusok és láthatóság
// ============================================================


// --- Láthatósági módosítók -------------------------------------

class Student
{
    private string $id;
    public string $name;
    protected int $age;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    protected function getAge(): int
    {
        return $this->age;
    }

    public function getInfo(): string
    {
        return "Név: {$this->name}, kor: {$this->age}, azonosító: {$this->id}";
    }
}

$student = new Student();
$student->name = "Kovács János";   // public: működik
$student->setId("S12345");
$student->setAge(20);

echo $student->getInfo() . PHP_EOL;
echo $student->getId()   . PHP_EOL;  // S12345

// $student->id  = "X";   // hiba: private
// $student->age = 21;    // hiba: protected


// --- Readonly tulajdonság (PHP 8.1+) ---------------------------

class Course
{
    public readonly string $code;
    public string $title;

    public function __construct(string $code, string $title)
    {
        $this->code  = $code;
        $this->title = $title;
    }
}

$course = new Course("WEB101", "Webprogramozás");
echo $course->code  . PHP_EOL;  // WEB101
echo $course->title . PHP_EOL;  // Webprogramozás

$course->title = "PHP programozás";  // működik, nem readonly
// $course->code = "WEB102";         // hiba: readonly property


// --- Readonly osztály (PHP 8.2+) -------------------------------

readonly class Coordinate
{
    public function __construct(
        public float $lat,
        public float $lon
    ) {}

    public function label(): string
    {
        return "{$this->lat}, {$this->lon}";
    }
}

$coord = new Coordinate(46.77, 23.59);
echo $coord->label() . PHP_EOL;  // 46.77, 23.59

// $coord->lat = 0.0;  // hiba: minden tulajdonság readonly
