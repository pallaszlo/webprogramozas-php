<?php

// =============================================================
// 3.11. Traitek
// =============================================================


// --- 3.44. Több trait használata -----------------------------
// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
// Az Identifiable trait a 3.45. kódpéldából
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

trait Timestampable
{
    private DateTime $createdAt;

    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}

// Az Identifiable trait az előző példából származik
class Student
{
    use Identifiable, Timestampable;

    public function __construct(public string $name)
    {
        $this->generateId();    // Identifiable trait metódusa
        $this->setCreatedAt();  // Timestampable trait metódusa
    }
}

$student = new Student("Kovács János");

echo $student->getId();
echo $student->getCreatedAt();
