<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.37. __get() és __set() használata ---------------------
class Student
{
    private array $data = [];

    public function __get(string $name): mixed
    {
        return $this->data[$name]
            ?? "A(z) '$name' tulajdonság nem létezik.";
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }
}

// Kiegészítés (nem szerepel a könyvben): az osztály használata
$student = new Student();
$student->name = "Kovács János";  // __set() fut le
echo $student->name . "\n";       // __get(): Kovács János
echo $student->email . "\n";      // __get(): A(z) 'email' tulajdonság nem létezik.
