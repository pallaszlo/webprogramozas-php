<?php

// ============================================================
// Trait-ek: alaphasználat, több trait, konfliktuskezelés
// Kapcsolódó fejezet: 3.7. Trait-ek
// ============================================================


// --- Alap trait ------------------------------------------------

trait Loggable
{
    public function log(string $message): void
    {
        echo "[" . static::class . "] " . date("H:i:s") . " – $message" . PHP_EOL;
    }
}

trait Timestampable
{
    private ?DateTime $createdAt = null;
    private ?DateTime $updatedAt = null;

    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt?->format("Y-m-d H:i:s");
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt?->format("Y-m-d H:i:s");
    }
}


// --- Trait-ek használata több osztályban -----------------------

class Student
{
    use Loggable, Timestampable;

    public function __construct(public string $name)
    {
        $this->setCreatedAt();
        $this->log("Hallgató létrehozva: $name");
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
        $this->touch();
        $this->log("Név módosítva: $name");
    }
}

class Order
{
    use Loggable, Timestampable;

    public function __construct(public string $item, public float $total)
    {
        $this->setCreatedAt();
        $this->log("Rendelés létrehozva: $item ($total RON)");
    }
}

$student = new Student("Kovács Anna");
$student->updateName("Kovács Anna Mária");
echo "Létrehozva: " . $student->getCreatedAt() . PHP_EOL;

$order = new Order("Laptop", 4500.0);
echo "Rendelés időpontja: " . $order->getCreatedAt() . PHP_EOL;


// --- Konfliktuskezelés -----------------------------------------

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

class MultilingualStudent
{
    use EnglishGreeting, HungarianGreeting {
        EnglishGreeting::greet  insteadof HungarianGreeting;  // angol az alapértelmezett
        HungarianGreeting::greet as greetHungarian;           // magyar elérhető aliasként
    }

    public function __construct(public string $name) {}
}

$ms = new MultilingualStudent("Tóth Béla");
echo $ms->greet()          . PHP_EOL;  // Hello!
echo $ms->greetHungarian() . PHP_EOL;  // Szia!


// --- Trait + öröklődés -----------------------------------------

trait Gradeable
{
    private array $grades = [];

    public function addGrade(string $subject, int $grade): void
    {
        $this->grades[$subject] = $grade;
    }

    public function average(): float
    {
        return empty($this->grades) ? 0.0 : array_sum($this->grades) / count($this->grades);
    }
}

class Person
{
    public function __construct(public string $name) {}
}

class GradedStudent extends Person
{
    use Gradeable;
}

$gs = new GradedStudent("Varga Éva");
$gs->addGrade("Matematika", 9);
$gs->addGrade("Fizika", 8);
echo "{$gs->name} átlaga: " . $gs->average() . PHP_EOL;  // 8.5
