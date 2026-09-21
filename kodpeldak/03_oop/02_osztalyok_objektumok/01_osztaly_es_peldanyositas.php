<?php

// =============================================================
// 3.2. Osztályok és objektumok
// =============================================================


// --- 3.1. Student osztály ------------------------------------
class Student
{
    public string $name;
    public int $age;

    public function introduce(): string
    {
        return "Szia, " . $this->name . " vagyok, " . $this->age . " éves.";
    }
}


// --- 3.2. Student osztály példányosítása ---------------------
$student = new Student();
$student->name = "Kovács János";
$student->age = 20;

echo $student->introduce();
// Kimenet: Szia, Kovács János vagyok, 20 éves.
