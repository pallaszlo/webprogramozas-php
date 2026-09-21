<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.11. Property hooks használata -------------------------
class Student
{
    public string $name {
        set(string $value) {
            // Automatikus formázás beállításkor
            $this->name = ucwords(strtolower(trim($value)));
        }
    }

    public int $age;
}

$student = new Student();
$student->name = "  kOVACS jAnos  ";  // a set hook automatikusan lefut
echo $student->name;  // Kimenet: Kovacs Janos

$student->name = "  vARGA aNNA  ";
echo $student->name;  // Kimenet: Varga Anna
