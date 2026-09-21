<?php

// =============================================================
// 3.8. Objektumok vizsgálata és összehasonlítása
// =============================================================


// --- 3.31. Objektumok összehasonlítása -----------------------
class Student
{
    private string $id;
    private string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

$student1 = new Student("S001", "Kovács Anna");
$student2 = new Student("S001", "Kovács Anna");
$student3 = $student1;

var_dump($student1 == $student2);   // bool(true)  - azonos tulajdonságok
var_dump($student1 === $student2);  // bool(false) - különböző példányok
var_dump($student1 === $student3);  // bool(true)  - ugyanarra a példányra hivatkoznak

// Tulajdonság módosítása az egyik példányon
$student3->setName("Nagy Péter");

echo $student1->getName();  // Kimenet: Nagy Péter
echo $student2->getName();  // Kimenet: Kovács Anna
