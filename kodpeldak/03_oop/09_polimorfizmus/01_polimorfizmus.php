<?php

// =============================================================
// 3.9. Polimorfizmus
// =============================================================


// --- 3.32. Példa polimorfizmusra -----------------------------
abstract class Shape
{
    abstract public function getArea(): float;
}

class Circle extends Shape
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getArea(): float
    {
        return pi() * $this->radius * $this->radius;
    }
}

class Rectangle extends Shape
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea(): float
    {
        return $this->width * $this->height;
    }
}

function printArea(Shape $shape): void
{
    echo "A terület: " . $shape->getArea() . "\n";
}

$circle = new Circle(5);
$rectangle = new Rectangle(4, 6);

printArea($circle);     // Kimenet: A terület: 78.539816339745
printArea($rectangle);  // Kimenet: A terület: 24
