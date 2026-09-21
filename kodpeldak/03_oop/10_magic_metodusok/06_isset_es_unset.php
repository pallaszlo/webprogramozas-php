<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.38. __isset() és __unset() használata -----------------
class Student
{
    private array $data = [
        'name' => 'Kovács János',
        'age' => 20
    ];

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }
}

// Kiegészítés (nem szerepel a könyvben): az osztály használata
$student = new Student();
var_dump(isset($student->name));  // __isset(): bool(true)
unset($student->name);            // __unset() fut le
var_dump(isset($student->name));  // __isset(): bool(false)
