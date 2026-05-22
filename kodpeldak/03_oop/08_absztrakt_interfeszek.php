<?php

// ============================================================
// Absztrakt osztályok, interfészek, polimorfizmus
// Kapcsolódó fejezet: 3.6. Absztrakt osztályok és interfészek
// ============================================================


// --- Absztrakt osztály -----------------------------------------

abstract class Shape
{
    public function __construct(protected string $color) {}

    abstract public function area(): float;
    abstract public function perimeter(): float;

    public function getColor(): string
    {
        return $this->color;
    }

    public function describe(): string
    {
        return sprintf(
            "%s | szín: %s | terület: %.2f | kerület: %.2f",
            static::class,
            $this->color,
            $this->area(),
            $this->perimeter()
        );
    }
}

class Circle extends Shape
{
    public function __construct(string $color, private float $radius)
    {
        parent::__construct($color);
    }

    public function area(): float
    {
        return M_PI * $this->radius ** 2;
    }

    public function perimeter(): float
    {
        return 2 * M_PI * $this->radius;
    }
}

class Rectangle extends Shape
{
    public function __construct(string $color, private float $width, private float $height)
    {
        parent::__construct($color);
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }

    public function perimeter(): float
    {
        return 2 * ($this->width + $this->height);
    }
}


// --- Interfész -------------------------------------------------

interface Printable
{
    public function print(): void;
}

interface Exportable
{
    public function exportAsCsv(): string;
}

// Egy osztály több interfészt is implementálhat
class Report implements Printable, Exportable
{
    private array $rows = [];

    public function addRow(string $label, float $value): void
    {
        $this->rows[] = [$label, $value];
    }

    public function print(): void
    {
        foreach ($this->rows as [$label, $value]) {
            printf("%-20s %.2f\n", $label, $value);
        }
    }

    public function exportAsCsv(): string
    {
        $lines = [];
        foreach ($this->rows as [$label, $value]) {
            $lines[] = "$label,$value";
        }
        return implode("\n", $lines);
    }
}


// --- Polimorfizmus ---------------------------------------------

// Ugyanaz a függvény bármilyen Shape-leszármazottal működik
function printShapeInfo(Shape $shape): void
{
    echo $shape->describe() . PHP_EOL;
}

$shapes = [
    new Circle("piros", 5),
    new Rectangle("kék", 4, 6),
    new Circle("zöld", 3),
];

foreach ($shapes as $shape) {
    printShapeInfo($shape);
}

echo PHP_EOL;

// Report interfész-használat
$report = new Report();
$report->addRow("Bevétel", 1250.50);
$report->addRow("Kiadás",   875.30);
$report->addRow("Egyenleg", 375.20);

$report->print();
echo PHP_EOL;
echo $report->exportAsCsv() . PHP_EOL;
