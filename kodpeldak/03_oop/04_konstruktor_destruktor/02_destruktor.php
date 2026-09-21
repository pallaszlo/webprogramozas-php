<?php

// =============================================================
// 3.4. Konstruktor és destruktor
// =============================================================


// --- 3.19. Destruktor használata -----------------------------
class Student
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        echo "{$this->name} hallgató létrehozva.<br>";
    }

    public function __destruct()
    {
        echo "{$this->name} hallgató objektum megsemmisítve.<br>";
    }
}

function createStudent()
{
    $student = new Student("Péter");
    echo "A függvényen belül.<br>";
    // A függvény végén az objektum megsemmisül
}

createStudent();
echo "A függvényhívás után.<br>";

// Kimenet:
// Péter hallgató létrehozva.
// A függvényen belül.
// Péter hallgató objektum megsemmisítve.
// A függvényhívás után.
