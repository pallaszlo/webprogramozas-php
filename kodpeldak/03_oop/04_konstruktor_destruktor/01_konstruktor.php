<?php

// =============================================================
// 3.4. Konstruktor és destruktor
// =============================================================


// --- 3.18. Konstruktor használata ----------------------------
class Student
{
    private string $id;
    private string $name;
    private int $age;

    public function __construct(string $id, string $name, int $age)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }

    public function introduce(): string
    {
        return "Szia, {$this->name} vagyok, {$this->age} éves, azonosító: {$this->id}.";
    }
}

// Objektum létrehozása konstruktorral
$student = new Student("S12345", "Molnár Eszter", 20);
echo $student->introduce();
// Kimenet: Szia, Molnár Eszter vagyok, 20 éves, azonosító: S12345.
