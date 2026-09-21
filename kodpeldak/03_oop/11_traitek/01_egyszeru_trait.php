<?php

// =============================================================
// 3.11. Traitek
// =============================================================


// --- 3.43. Egyszerű trait definiálása és használata ----------
// Trait definiálása
trait Identifiable
{
    private string $id;

    public function generateId(): void
    {
        $this->id = uniqid('ID_', true);
    }

    public function getId(): string
    {
        return $this->id;
    }
}

// Trait használata a Student osztályban
class Student
{
    use Identifiable;

    public function __construct(
        public string $name,
        public int $age
    ) {
        $this->generateId();
    }

    public function introduce(): string
    {
        return "Hallgató: {$this->name} (azonosító: {$this->getId()})";
    }
}

$student = new Student("Kovács János", 20);

echo $student->introduce();
// Kimenet: Hallgató: Kovács János (azonosító: ID_...)

echo $student->getId();
// A trait metódusa közvetlenül elérhető
