<?php

// ============================================================
// Kompozíció és aggregáció (has-a kapcsolat)
// Kapcsolódó fejezet: 3.5. Kompozíció és aggregáció
// ============================================================


// --- Kompozíció: az objektum életciklusa kötött ---------------

class Engine
{
    public function __construct(private int $horsepower) {}

    public function start(): string
    {
        return "{$this->horsepower} lóerős motor beindult.";
    }
}

class Car
{
    private Engine $engine;

    public function __construct(int $horsepower)
    {
        // Az Engine a Car részeként jön létre, önállóan nem létezhet
        $this->engine = new Engine($horsepower);
    }

    public function start(): string
    {
        return $this->engine->start();
    }
}

$car = new Car(150);
echo $car->start() . PHP_EOL;  // 150 lóerős motor beindult.


// --- Aggregáció: a függőség kívülről kerül átadásra -----------

class Logger
{
    public function log(string $message): void
    {
        echo "[LOG] " . date("H:i:s") . " – $message" . PHP_EOL;
    }
}

class UserService
{
    // A Logger önállóan is létezhet, és más osztályok is használhatják
    public function __construct(private Logger $logger) {}

    public function register(string $name): void
    {
        // ... regisztrációs logika
        $this->logger->log("Új felhasználó regisztrált: $name");
    }

    public function delete(string $name): void
    {
        // ... törlési logika
        $this->logger->log("Felhasználó törölve: $name");
    }
}

class OrderService
{
    // Ugyanazt a Logger példányt veszi át
    public function __construct(private Logger $logger) {}

    public function placeOrder(string $item): void
    {
        $this->logger->log("Rendelés leadva: $item");
    }
}

// Egy Logger példány több service-ben is felhasználható
$logger       = new Logger();
$userService  = new UserService($logger);
$orderService = new OrderService($logger);

$userService->register("Kovács Anna");
$orderService->placeOrder("Laptop");
$userService->delete("Kovács Anna");
