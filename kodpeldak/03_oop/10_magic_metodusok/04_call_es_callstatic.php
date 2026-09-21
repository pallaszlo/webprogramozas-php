<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.36. __call() és __callStatic() használata -------------
class Student
{
    public function __call(string $name, array $arguments): void
    {
        echo "Nem létező metódus hívása: '$name', argumentumok: "
            . implode(', ', $arguments) . "\n";
    }

    public static function __callStatic(string $name, array $arguments): void
    {
        echo "Nem létező statikus metódus hívása: '$name', argumentumok: "
            . implode(', ', $arguments) . "\n";
    }
}

// Kiegészítés (nem szerepel a könyvben): az osztály használata
$student = new Student();
$student->enrollCourse("Webprogramozás", 5);
// Nem létező metódus hívása: 'enrollCourse', argumentumok: Webprogramozás, 5

Student::findByName("Kovács");
// Nem létező statikus metódus hívása: 'findByName', argumentumok: Kovács
