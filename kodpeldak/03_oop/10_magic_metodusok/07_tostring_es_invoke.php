<?php

// =============================================================
// 3.10. Metódustúlterhelés és magic metódusok
// =============================================================


// --- 3.39. __toString() használata ---------------------------
class Student
{
    private string $name;
    private string $id;

    public function __construct(string $name, string $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function __toString(): string
    {
        return "Hallgató: {$this->name} (azonosító: {$this->id})";
    }
}

// Kiegészítés (nem szerepel a könyvben): az osztály használata
$student = new Student("Kovács Anna", "S12345");
echo $student . "\n";  // Hallgató: Kovács Anna (azonosító: S12345)


// --- 3.40. __invoke() használata -----------------------------
class GradeCalculator
{
    private array $weights;

    public function __construct(array $weights)
    {
        $this->weights = $weights;
    }

    public function __invoke(array $scores): float
    {
        $total = 0;

        foreach ($scores as $subject => $score) {
            $total += $score * ($this->weights[$subject] ?? 1);
        }

        return $total / array_sum($this->weights);
    }
}

// Kiegészítés (nem szerepel a könyvben): az osztály használata
$calculator = new GradeCalculator(["Webprogramozás" => 2, "Adatbázisok" => 1]);

// Az objektum függvényként hívható: __invoke() fut le
echo $calculator(["Webprogramozás" => 9, "Adatbázisok" => 6]) . "\n";  // 8
