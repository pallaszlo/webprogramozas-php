<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.33. Opcionális paraméterek használata -----------------
class Student
{
    public function displayInfo($name, $age = null, $grade = null)
    {
        echo "Név: $name";
        if ($age !== null) {
            echo ", Kor: $age";
        }
        if ($grade !== null) {
            echo ", Jegy: $grade";
        }
        echo "\n";
    }
}

$student = new Student();
$student->displayInfo("Kovács János");
$student->displayInfo("Varga Anna", 20);
$student->displayInfo("Nagy Péter", 22, "5");
