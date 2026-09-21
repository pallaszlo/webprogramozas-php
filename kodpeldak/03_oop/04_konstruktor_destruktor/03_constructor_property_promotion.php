<?php

// =============================================================
// 3.4. Konstruktor és destruktor
// =============================================================


// --- 3.20. Hagyományos és constructor property promotion -----
// Hagyományos mód (PHP < 8.0)
class LegacyStudent
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
}

// Constructor property promotion (PHP 8.0+)
class Student
{
    public function __construct(
        private string $id,
        private string $name,
        private int $age
    ) {
        // Nincs szükség külön értékadásokra,
        // a paraméterek automatikusan tulajdonságokká válnak
    }

    public function introduce(): string
    {
        return "Szia, {$this->name} vagyok, {$this->age} éves, azonosító: {$this->id}.";
    }
}

$student = new Student("S12345", "Molnár Eszter", 20);
echo $student->introduce();
