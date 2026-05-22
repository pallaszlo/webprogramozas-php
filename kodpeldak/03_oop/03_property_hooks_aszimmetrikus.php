<?php

// ============================================================
// Property hooks és aszimmetrikus láthatóság (PHP 8.4+)
// Kapcsolódó fejezet: 3.2. Tulajdonságok, metódusok és láthatóság
// ============================================================


// --- Set hook: automatikus formázás ----------------------------

class Student
{
    public string $name {
        set(string $value) {
            $this->name = ucwords(strtolower(trim($value)));
        }
    }

    public int $age;
}

$student = new Student();
$student->name = "  kOVACS jAnos  ";
echo $student->name . PHP_EOL;  // Kovacs Janos

$student->name = "  vARGA aNNA  ";
echo $student->name . PHP_EOL;  // Varga Anna


// --- Get + set hook: számított tulajdonság ---------------------

class Circle
{
    public float $radius {
        set(float $value) {
            if ($value <= 0) {
                throw new InvalidArgumentException("A sugár pozitív kell legyen.");
            }
            $this->radius = $value;
        }
    }

    public float $area {
        get {
            return M_PI * $this->radius ** 2;
        }
    }
}

$circle = new Circle();
$circle->radius = 5.0;
echo round($circle->area, 2) . PHP_EOL;  // 78.54

$circle->radius = 3.0;
echo round($circle->area, 2) . PHP_EOL;  // 28.27  (automatikusan újraszámolt)


// --- Aszimmetrikus láthatóság (PHP 8.4+) ----------------------

class BankAccount
{
    public private(set) float $balance;

    public function __construct(float $initialBalance)
    {
        $this->balance = $initialBalance;
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Az összeg pozitív kell legyen.");
        }
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount > $this->balance) {
            throw new RuntimeException("Nincs elegendő fedezet.");
        }
        $this->balance -= $amount;
    }
}

$account = new BankAccount(1000.0);
echo $account->balance . PHP_EOL;  // 1000 (olvasható: public)

$account->deposit(500.0);
echo $account->balance . PHP_EOL;  // 1500

// $account->balance = 9999.0;  // hiba: private(set)
