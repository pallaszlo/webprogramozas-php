<?php

// =============================================================
// 3.3. Tulajdonságok, metódusok és láthatóság
// =============================================================


// --- 3.8. Statikus tulajdonság a Student osztályban ----------
class Student
{
    private static int $maxCredits = 30;
    private int $enrolledCredits = 0;

    // Rövidített konstruktor (constructor property promotion),
    // részletesen a Konstruktor és destruktor alfejezetben
    public function __construct(public string $name) {}

    public function enroll(int $credits): bool
    {
        if ($this->enrolledCredits + $credits > self::$maxCredits) {
            return false;
        }
        $this->enrolledCredits += $credits;
        return true;
    }

    public static function setMaxCredits(int $max): void
    {
        self::$maxCredits = $max;
    }
}

$s1 = new Student('Kovács János');
$s1->enroll(20);
$s1->enroll(15);  // false: 35 > 30
