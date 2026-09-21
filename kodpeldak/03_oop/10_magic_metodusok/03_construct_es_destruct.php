<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.35. __construct() és __destruct() használata ----------
class Student
{
    private string $name;
    private string $id;

    public function __construct(string $name, string $id)
    {
        $this->name = $name;
        $this->id = $id;

        echo "$name hallgató felvételre került (azonosító: $id).\n";
    }

    public function __destruct()
    {
        echo "$this->name hallgató elvégezte a tanulmányait (azonosító: $this->id).\n";
    }
}

$student = new Student("Kovács Anna", "S12345");
unset($student);
