<?php

// =============================================================
// 3.15. Hibakezelés és kivételkezelés
// =============================================================


// --- 3.61. Kivétel dobása ------------------------------------
function divide(float $a, float $b): float
{
    if ($b == 0.0) {
        throw new DivisionByZeroError(
            "Nullával való osztás"
        );
    }

    return $a / $b;
}

function processNumber(mixed $number): float
{
    if (!is_numeric($number)) {
        throw new InvalidArgumentException(
            "Az argumentumnak számnak kell lennie"
        );
    }

    return (float)$number * 2;
}


// --- 3.62. Kivétel kezelése ----------------------------------
try {
    echo divide(10, 0);

} catch (DivisionByZeroError $e) {
    echo "Kivétel: "
        . $e->getMessage() . "\n";
}

try {
    echo processNumber("nem szám");

} catch (InvalidArgumentException $e) {
    echo "Érvénytelen argumentum: "
        . $e->getMessage() . "\n";
}


// --- 3.63. Több kivétel kezelése -----------------------------
try {
    echo divide(10, 0);

} catch (DivisionByZeroError $e) {
    echo "Osztási hiba: "
        . $e->getMessage() . "\n";

} catch (Exception $e) {
    echo "Általános hiba: "
        . $e->getMessage() . "\n";
}


// --- 3.64. Több kivételtípus egy catch blokkban --------------
try {
    // Kód, amely kivételt dobhat

} catch (
    InvalidArgumentException | LogicException $e
) {
    echo "Kivétel: "
        . $e->getMessage();
}


// --- 3.65. Finally blokk használata --------------------------
function testFinally(): bool
{
    try {
        throw new Exception("Teszt kivétel");

    } catch (Exception $e) {
        echo "Kivétel: "
            . $e->getMessage() . "\n";

        return false;

    } finally {
        echo "A finally blokk lefutott\n";
    }
}

testFinally();


// --- 3.66. A StudentGradeException osztály definíciója -------
class StudentGradeException extends Exception
{
    public function __construct(
        string $message,
        protected string $studentId
    ) {
        parent::__construct($message);
    }

    public function getStudentId(): string
    {
        return $this->studentId;
    }
}


// --- 3.67. A Student osztály kivételkezeléssel ---------------
class Student
{
    private ?int $grade = null;

    public function __construct(
        private string $id,
        private string $name
    ) {}

    public function setGrade(int $grade): void
    {
        if ($grade < 1 || $grade > 10) {
            throw new StudentGradeException(
                "Érvénytelen jegy. Az értéknek "
                . "1 és 10 közé kell esnie.",
                $this->id
            );
        }

        $this->grade = $grade;
    }
}

// Használat:
try {
    $student = new Student(
        "S001",
        "Kovács János"
    );

    $student->setGrade(11);

} catch (StudentGradeException $e) {
    echo "Hiba: "
        . $e->getMessage() . "\n";

    echo "Hallgató azonosító: "
        . $e->getStudentId() . "\n";
}


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Saját kivételosztályok a beépített kivételhierarchiára építve
class InsufficientFundsException extends RuntimeException
{
    public function __construct(
        private float $requested,
        private float $available
    ) {
        parent::__construct("Nincs elegendő fedezet: {$requested} RON kérve, {$available} RON elérhető.");
    }
}

class NegativeAmountException extends InvalidArgumentException
{
    public function __construct(float $amount)
    {
        parent::__construct("Az összeg nem lehet negatív: $amount RON.");
    }
}

class BankAccount
{
    public function __construct(private float $balance) {}

    public function withdraw(float $amount): void
    {
        if ($amount < 0) {
            throw new NegativeAmountException($amount);
        }
        if ($amount > $this->balance) {
            throw new InsufficientFundsException($amount, $this->balance);
        }
        $this->balance -= $amount;
        echo "Kifizetés: $amount RON. Egyenleg: {$this->balance} RON.\n";
    }
}

$account = new BankAccount(500.0);

foreach ([200.0, -50.0, 400.0] as $amount) {
    try {
        $account->withdraw($amount);
    } catch (NegativeAmountException $e) {
        echo "Hibás összeg: " . $e->getMessage() . "\n";
    } catch (InsufficientFundsException $e) {
        echo "Fedezethiány: " . $e->getMessage() . "\n";
    }
}
// Kifizetés: 200 RON. Egyenleg: 300 RON.
// Hibás összeg: Az összeg nem lehet negatív: -50 RON.
// Fedezethiány: Nincs elegendő fedezet: 400 RON kérve, 300 RON elérhető.
