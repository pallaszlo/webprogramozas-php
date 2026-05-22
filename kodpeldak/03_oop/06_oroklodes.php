<?php

// ============================================================
// Öröklődés: extends, parent::, metódus-felülírás
// Kapcsolódó fejezet: 3.4. Öröklődés
// ============================================================


// --- Alap öröklődési példa -------------------------------------

class Person
{
    protected string $name;
    protected int    $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age  = $age;
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

    // Metódus felülírása, szülő implementáció felhasználásával
    public function introduce(): string
    {
        return parent::introduce() . " Hallgatói azonosítóm: {$this->id}.";
    }

    public function study(): string
    {
        return "{$this->name} tanul.";
    }
}

class Teacher extends Person
{
    public function __construct(string $name, int $age, private string $subject)
    {
        parent::__construct($name, $age);
    }

    public function introduce(): string
    {
        return parent::introduce() . " A(z) {$this->subject} tantárgyat tanítom.";
    }
}

$person  = new Person("Szabó Péter", 45);
$student = new Student("S001", "Molnár Eszter", 20);
$teacher = new Teacher("Nagy Gábor", 40, "Webprogramozás");

echo $person->introduce()  . PHP_EOL;
// Szia, Szabó Péter vagyok, 45 éves.

echo $student->introduce() . PHP_EOL;
// Szia, Molnár Eszter vagyok, 20 éves. Hallgatói azonosítóm: S001.

echo $student->study()     . PHP_EOL;
// Molnár Eszter tanul.

echo $teacher->introduce() . PHP_EOL;
// Szia, Nagy Gábor vagyok, 40 éves. A(z) Webprogramozás tantárgyat tanítom.


// --- instanceof ellenőrzés -------------------------------------

var_dump($student instanceof Student);  // bool(true)
var_dump($student instanceof Person);   // bool(true)
var_dump($teacher instanceof Student);  // bool(false)
