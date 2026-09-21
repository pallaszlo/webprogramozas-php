<?php

// =============================================================
// 3.4. Konstruktor és destruktor
// =============================================================


// --- 3.21. Property promotion különböző módosítókkal ---------
class Student
{
    public function __construct(
        public readonly string $id,     // Readonly tulajdonság
        public string $name,            // Public tulajdonság
        private int $age,               // Private tulajdonság
        protected string $email         // Protected tulajdonság
    ) {}

    public function getAge(): int
    {
        return $this->age;  // A private tulajdonság az osztályon belül elérhető
    }
}

$student = new Student(
    "S12345",
    "Kovács János",
    20,
    "kovacs.janos@example.com"
);

echo $student->name;  // Működik (public)
echo $student->id;    // Működik (readonly, de olvasható)

// $student->id = "S999";  // Hiba: readonly property
// echo $student->age;     // Hiba: private property
