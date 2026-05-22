<?php

// ============================================================
// Konstruktor, destruktor, constructor property promotion
// Kapcsolódó fejezet: 3.3. Konstruktor és destruktor
// ============================================================


// --- Hagyományos konstruktor -----------------------------------

class Student
{
    private string $id;
    private string $name;
    private int    $age;

    public function __construct(string $id, string $name, int $age)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->age  = $age;
    }

    public function introduce(): string
    {
        return "Szia, {$this->name} vagyok, {$this->age} éves. Azonosító: {$this->id}.";
    }
}

$s = new Student("S001", "Molnár Eszter", 20);
echo $s->introduce() . PHP_EOL;


// --- Constructor property promotion (PHP 8.0+) ----------------

class Course
{
    public function __construct(
        public readonly string $code,
        public string          $title,
        private int            $credits
    ) {}

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function summary(): string
    {
        return "{$this->code} – {$this->title} ({$this->credits} kredit)";
    }
}

$course = new Course("WEB101", "Webprogramozás", 5);
echo $course->summary()     . PHP_EOL;   // WEB101 – Webprogramozás (5 kredit)
echo $course->getCredits()  . PHP_EOL;   // 5
// $course->code = "X";                  // hiba: readonly


// --- Destruktor ------------------------------------------------

class DatabaseConnection
{
    private string $dsn;

    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;
        echo "Kapcsolat megnyitva: {$this->dsn}" . PHP_EOL;
    }

    public function __destruct()
    {
        echo "Kapcsolat lezárva: {$this->dsn}" . PHP_EOL;
    }
}

function openConnection(): void
{
    $db = new DatabaseConnection("mysql:host=localhost;dbname=test");
    echo "Lekérdezés futtatása..." . PHP_EOL;
    // A függvény végén $db megsemmisül, __destruct meghívódik
}

openConnection();
echo "A függvény lefutott." . PHP_EOL;

// Kimenet:
// Kapcsolat megnyitva: mysql:host=localhost;dbname=test
// Lekérdezés futtatása...
// Kapcsolat lezárva: mysql:host=localhost;dbname=test
// A függvény lefutott.
