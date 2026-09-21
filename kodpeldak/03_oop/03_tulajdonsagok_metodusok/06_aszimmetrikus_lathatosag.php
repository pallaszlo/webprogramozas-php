<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.13. Aszimmetrikus láthatóság --------------------------
class Student
{
    public private(set) string $id;
    public private(set) string $name;
    public private(set) int $age;

    public function setData(string $id, string $name, int $age): void
    {
        $this->id = $id;      // belülről módosítható
        $this->name = $name;  // belülről módosítható
        $this->age = $age;    // belülről módosítható
    }

    public function haveBirthday(): void
    {
        $this->age++;  // belülről módosítható
    }
}

$student = new Student();
$student->setData("S12345", "Kovács János", 20);

// Olvasás: működik (public)
echo $student->name;  // Kimenet: Kovács János
echo $student->age;   // Kimenet: 20

// Írás: hiba (private set)
// $student->name = "Varga Anna";  // Hiba: Cannot modify private(set) property
// $student->age = 21;             // Hiba: Cannot modify private(set) property

// de metóduson keresztül módosítható:
$student->haveBirthday();  // működik
echo $student->age;        // Kimenet: 21
