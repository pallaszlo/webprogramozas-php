<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.9. Readonly tulajdonság használata --------------------
class Student
{
    public readonly string $id;
    public string $name;
    public int $age;

    public function setId(string $id): void
    {
        $this->id = $id;  // első értékadás: működik
    }
}

$student = new Student();
$student->setId("S12345");
$student->name = "Kovács János";
$student->age = 20;

echo $student->id;   // működik: S12345

// $student->id = "S99999";  // hiba: cannot modify readonly property
$student->name = "Varga Anna";  // működik, mert nem readonly
$student->age = 21;             // működik, mert nem readonly


// --- 3.10. Readonly osztály ----------------------------------
readonly class StudentRecord
{
    // Rövidített konstruktor (constructor property promotion),
    // részletesen a Konstruktor és destruktor alfejezetben
    public function __construct(
        public string $id,
        public string $name,
        public int $enrollmentYear
    ) {}
}

$record = new StudentRecord("S12345", "Kovács János", 2026);

// minden tulajdonság readonly, egyik sem módosítható többé:
// $record->name = "Varga Anna";  // hiba
// $record->enrollmentYear = 2025;  // hiba
