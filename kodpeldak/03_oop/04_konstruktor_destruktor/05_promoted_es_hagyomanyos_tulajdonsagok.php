<?php

// =============================================================
// 3.4. Konstruktor és destruktor
// =============================================================


// --- 3.22. Promoted és hagyományos tulajdonságok -------------
class Student
{
    private array $grades = [];  // Hagyományos tulajdonság

    public function __construct(
        public readonly string $id,  // Promoted tulajdonság
        public string $name,         // Promoted tulajdonság
        private int $age             // Promoted tulajdonság
    ) {
        // További inicializáló logika is írható ide
        $this->grades = [
            "Webprogramozás" => 0,
            "Adatbázisok" => 0
        ];
    }

    public function addGrade(string $subject, int $grade): void
    {
        $this->grades[$subject] = $grade;
    }
}
