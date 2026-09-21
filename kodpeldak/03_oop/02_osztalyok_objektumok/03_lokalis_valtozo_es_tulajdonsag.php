<?php

// =============================================================
// 3.2. Osztályok és objektumok
// =============================================================


// --- 3.4. Lokális változó és tulajdonság megkülönböztetése ---
class Student
{
    public string $name;

    public function setName(string $name): void
    {
        // $name: a metódus paramétere (lokális változó)
        // $this->name: az objektum tulajdonsága
        $this->name = $name;
    }

    public function greet(string $greeting): string
    {
        // $greeting: csak a metóduson belül létezik
        // $this->name: az objektum tulajdonsága, az osztályon belül bárhol elérhető
        return $greeting . ", " . $this->name . " vagyok.";
    }
}

$student = new Student();
$student->setName("Eszter");

echo $student->greet("Szia");
// Kimenet: Szia, Eszter vagyok.
