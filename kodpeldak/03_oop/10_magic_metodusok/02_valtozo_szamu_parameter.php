<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.34. Változó számú paraméter használata ----------------
class Student
{
    public function enroll(...$courses)
    {
        echo "Felvett kurzusok: " . implode(", ", $courses) . "\n";
    }
}

$student = new Student();
$student->enroll("Matematika");
$student->enroll("Fizika", "Kémia");
$student->enroll("Biológia", "Angol", "Rajz");
