<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.41. __clone() használata ------------------------------
class Student
{
    public string $name;
    public array $courses = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __clone(): void
    {
        $this->courses = [];

        echo "{$this->name} hallgató klónozva, üres kurzuslistával.\n";
    }
}

$s1 = new Student("Kovács János");
$s1->courses[] = "Webprogramozás";

$s2 = clone $s1;  // Kimenet: Kovács János hallgató klónozva, üres kurzuslistával.
echo count($s1->courses);  // 1
echo count($s2->courses);  // 0
