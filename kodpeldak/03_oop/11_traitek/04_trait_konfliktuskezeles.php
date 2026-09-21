<?php

// =============================================================
// 3.11. Traitek
// =============================================================


// --- 3.46. Konfliktuskezelés traitek között ------------------
trait EnglishGreeting
{
    public function greet(): string
    {
        return "Hello!";
    }
}

trait HungarianGreeting
{
    public function greet(): string
    {
        return "Szia!";
    }
}

class Student
{
    use EnglishGreeting, HungarianGreeting {
        EnglishGreeting::greet insteadof HungarianGreeting;
        HungarianGreeting::greet as greetHungarian;
    }

    public function __construct(public string $name) {}
}

$student = new Student("Kovács János");

echo $student->greet();
echo $student->greetHungarian();


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Ugyanaz a trait több, egymással nem rokon osztályban is használható.
trait Loggable
{
    public function log(string $message): void
    {
        echo "[" . static::class . "] $message\n";
    }
}

class Teacher
{
    use Loggable;

    public function __construct(public string $name)
    {
        $this->log("Oktató létrehozva: $name");
    }
}

class Order
{
    use Loggable;

    public function __construct(public string $item, public float $total)
    {
        $this->log("Rendelés létrehozva: $item ($total RON)");
    }
}

$teacher = new Teacher("Dr. Szabó Éva");  // [Teacher] Oktató létrehozva: Dr. Szabó Éva
$order = new Order("Laptop", 4500.0);     // [Order] Rendelés létrehozva: Laptop (4500 RON)
