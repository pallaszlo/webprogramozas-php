<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.42. Magic konstansok használata -----------------------

namespace School;

class Student
{
    public function displayInfo(): void
    {
        echo "Osztály: " . __CLASS__ . "\n";     // School\Student
        echo "Metódus: " . __METHOD__ . "\n";    // School\Student::displayInfo
        echo "Függvény: " . __FUNCTION__ . "\n"; // displayInfo
        echo "Névtér: " . __NAMESPACE__ . "\n";  // School
        echo "Fájl: " . __FILE__ . "\n";         // C:\xampp\htdocs\student.php
        echo "Sor: " . __LINE__ . "\n";          // a sor száma a fájlban, pl. 13
    }
}

$student = new Student();
$student->displayInfo();
