<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.12. Számított tulajdonság property hookkal ------------
class Student
{
    private int $birthYear;
    public string $name;

    public int $age {
        get {
            // Életkor számítása lekérdezéskor
            return date('Y') - $this->birthYear;
        }
        set(int $value) {
            // Születési év számítása beállításkor
            $this->birthYear = date('Y') - $value;
        }
    }
}

$student = new Student();
$student->name = "Kovács János";
$student->age = 20;  // set hook: kiszámítja a születési évet (az aktuális évből)

echo $student->age;  // get hook: az aktuális évből számolja vissza
// Kimenet: 20
