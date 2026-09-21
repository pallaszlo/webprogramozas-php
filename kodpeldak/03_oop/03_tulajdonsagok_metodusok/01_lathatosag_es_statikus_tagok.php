<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.5. Student osztály különböző láthatóságú tagokkal -----
class Student
{
    private string $id;
    public string $name;
    protected int $age;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    protected function getAge(): int
    {
        return $this->age;
    }

    public function introduce(): string
    {
        return "Szia, " . $this->name . " vagyok, " . $this->age . " éves.";
    }

    public function getInfo(): string
    {
        // belülről a private és protected tagok is elérhetők
        return "Név: " . $this->name . ", Kor: " . $this->getAge() . ", Azonosító: " . $this->getId();
    }
}


// --- 3.6. Student osztály használata és láthatósági szabályok ---
$student = new Student();
$student->name = "Kovács János";  // működik, mert public
$student->setId("S12345");
$student->setAge(20);

echo $student->introduce();  // működik, mert public metódus
echo $student->getInfo();    // működik, mert public metódus

// echo $student->age;       // hiba: protected property nem érhető el
// echo $student->getAge();  // hiba: protected metódus nem érhető el
// echo $student->id;        // hiba: private property nem érhető el

// de a public getter használható:
echo $student->getId();  // működik: S12345


// --- 3.7. Statikus tulajdonság és metódus --------------------
class Counter
{
    private static int $count = 0;

    public static function increment(): void
    {
        self::$count++;
    }

    public static function getCount(): int
    {
        return self::$count;
    }
}

Counter::increment();
Counter::increment();
echo Counter::getCount();  // 2
