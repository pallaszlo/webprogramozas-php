<?php

// ============================================================
// Hibakezelés és kivételkezelés: try/catch/finally, saját kivételek
// Kapcsolódó fejezet: 3.11. Hibakezelés és kivételkezelés
// ============================================================


// --- Alap kivételkezelés ---------------------------------------

function divide(float $a, float $b): float
{
    if ($b == 0) {
        throw new DivisionByZeroError("Nullával való osztás nem lehetséges.");
    }
    return $a / $b;
}

try {
    echo divide(10, 2)  . PHP_EOL;  // 5
    echo divide(10, 0)  . PHP_EOL;  // kivételt dob
} catch (DivisionByZeroError $e) {
    echo "Hiba: " . $e->getMessage() . PHP_EOL;
}


// --- Több catch ág + finally -----------------------------------

function parseAge(string $input): int
{
    if (!is_numeric($input)) {
        throw new InvalidArgumentException("Érvénytelen bemenet: '$input'");
    }
    $age = (int)$input;
    if ($age < 0 || $age > 150) {
        throw new RangeException("Az életkor tartományon kívül esik: $age");
    }
    return $age;
}

foreach (["25", "abc", "-5", "200"] as $input) {
    try {
        $age = parseAge($input);
        echo "Kor: $age" . PHP_EOL;
    } catch (InvalidArgumentException $e) {
        echo "Érvénytelen: " . $e->getMessage() . PHP_EOL;
    } catch (RangeException $e) {
        echo "Tartományhiba: " . $e->getMessage() . PHP_EOL;
    } finally {
        echo "  → feldolgozás vége: '$input'" . PHP_EOL;
    }
}


// --- Saját kivételosztályok ------------------------------------

class InsufficientFundsException extends RuntimeException
{
    public function __construct(
        private float $requested,
        private float $available
    ) {
        parent::__construct(
            "Nincs elegendő fedezet: {$requested} RON kérve, {$available} RON elérhető."
        );
    }

    public function getRequested(): float { return $this->requested; }
    public function getAvailable(): float { return $this->available; }
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
    public function __construct(
        private string $owner,
        private float  $balance
    ) {}

    public function withdraw(float $amount): void
    {
        if ($amount < 0) {
            throw new NegativeAmountException($amount);
        }
        if ($amount > $this->balance) {
            throw new InsufficientFundsException($amount, $this->balance);
        }
        $this->balance -= $amount;
        echo "Kifizetés: $amount RON. Egyenleg: {$this->balance} RON." . PHP_EOL;
    }
}

$account = new BankAccount("Kovács Anna", 500.0);

$amounts = [200.0, -50.0, 400.0];

foreach ($amounts as $amount) {
    try {
        $account->withdraw($amount);
    } catch (NegativeAmountException $e) {
        echo "Hibás összeg: " . $e->getMessage() . PHP_EOL;
    } catch (InsufficientFundsException $e) {
        echo "Fedezethiány: " . $e->getMessage() . PHP_EOL;
        echo "  Kért: "     . $e->getRequested() . " RON, elérhető: " . $e->getAvailable() . " RON" . PHP_EOL;
    }
}
