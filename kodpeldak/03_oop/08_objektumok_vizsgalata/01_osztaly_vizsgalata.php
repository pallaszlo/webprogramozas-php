<?php

// =============================================================
// 3.8. Objektumok vizsgálata és összehasonlítása
// =============================================================


// --- 3.30. Objektum osztályának vizsgálata -------------------
// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
// A Person és Student osztály a 3.23. kódpéldából
class Person
{
    protected string $name;
    protected int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

class Student extends Person
{
    private string $id;

    public function __construct(string $id, string $name, int $age)
    {
        parent::__construct($name, $age);
        $this->id = $id;
    }
}

$student = new Student("S12345", "Molnár Eszter", 21);

var_dump($student instanceof Student);  // bool(true)
var_dump($student instanceof Person);   // bool(true)
echo get_class($student);               // Student
var_dump(is_a($student, 'Person'));     // bool(true)
var_dump(is_subclass_of('Student', 'Person')); // bool(true)
