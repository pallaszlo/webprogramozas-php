<?php

// =============================================================
// 3.2. Osztályok és objektumok
// =============================================================


// --- 3.3. A $this kulcsszó használata ------------------------
class Student
{
    public string $name;
    public int $age;

    public function setName(string $name): void
    {
        $this->name = $name;  // az objektum name tulajdonságának beállítása
    }

    public function setAge(int $age): void
    {
        $this->age = $age;  // az objektum age tulajdonságának beállítása
    }

    public function introduce(): string
    {
        // az objektum tulajdonságainak elérése
        return "Szia, " . $this->name . " vagyok, " . $this->age . " éves.";
    }

    public function getInfo(): string
    {
        // saját metódus meghívása
        return $this->introduce() . " Örülök a találkozásnak!";
    }
}

$student = new Student();
$student->setName("Kovács János");
$student->setAge(20);

echo $student->introduce();
// Kimenet: Szia, Kovács János vagyok, 20 éves.

echo $student->getInfo();
// Kimenet: Szia, Kovács János vagyok, 20 éves. Örülök a találkozásnak!
