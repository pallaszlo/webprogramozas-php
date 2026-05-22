<?php

// ============================================================
// Osztályok és objektumok: definíció, példányosítás, $this
// Kapcsolódó fejezet: 3.1. Osztályok és objektumok
// ============================================================


// --- Osztály definíciója ---------------------------------------

class Student
{
    public string $name;
    public int $age;

    public function introduce(): string
    {
        return "Szia, {$this->name} vagyok, {$this->age} éves.";
    }

    public function getInfo(): string
    {
        return $this->introduce() . " Örülök a találkozásnak!";
    }
}


// --- Példányosítás és tulajdonságelérés ------------------------

$student = new Student();
$student->name = "Kovács János";
$student->age  = 20;

echo $student->introduce() . PHP_EOL;
// Kimenet: Szia, Kovács János vagyok, 20 éves.

echo $student->getInfo() . PHP_EOL;
// Kimenet: Szia, Kovács János vagyok, 20 éves. Örülök a találkozásnak!


// --- $this: lokális változó vs. tulajdonság --------------------

class Rectangle
{
    public float $width;
    public float $height;

    public function setDimensions(float $width, float $height): void
    {
        // $width, $height: metódus paraméterei (lokális változók)
        // $this->width, $this->height: az objektum tulajdonságai
        $this->width  = $width;
        $this->height = $height;
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }

    public function describe(): string
    {
        return "Téglalap: {$this->width} × {$this->height}, terület: " . $this->area();
    }
}

$rect = new Rectangle();
$rect->setDimensions(4.0, 6.0);

echo $rect->describe() . PHP_EOL;
// Kimenet: Téglalap: 4 × 6, terület: 24
