<?php

// =============================================================
// 3.5. Öröklődés
// =============================================================


// --- 3.23. Öröklődés példa: Person és Student osztályok ------
class Person
{
    protected string $name;
    protected int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function introduce(): string
    {
        return "Szia, {$this->name} vagyok, {$this->age} éves.";
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

    public function introduce(): string
    {
        return parent::introduce() . " A hallgatói azonosítóm: {$this->id}.";
    }

    public function study(): string
    {
        return "{$this->name} tanul.";
    }
}

$person = new Person("Kovács János", 30);
echo $person->introduce();
// Kimenet: Szia, Kovács János vagyok, 30 éves.

$student = new Student("S12345", "Molnár Eszter", 20);
echo $student->introduce();
// Kimenet: Szia, Molnár Eszter vagyok, 20 éves. A hallgatói azonosítóm: S12345.

echo $student->study();
// Kimenet: Molnár Eszter tanul.
