<?php

// =============================================================
// 3.6. Kompozíció és aggregáció
// =============================================================


// --- 3.25. Kompozíció példa ----------------------------------
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
        // A motor a kocsi része, külön nem létezik
        $this->engine = new Engine($horsepower);
    }

    public function start(): string
    {
        return $this->engine->start();
    }
}

$car = new Car(150);
echo $car->start(); // 150 lóerős motor beindult.


// --- 3.26. Aggregáció példa ----------------------------------
class Logger
{
    public function log(string $message): void
    {
        echo "[LOG] $message\n";
    }
}

class UserService
{
    // A Logger önállóan is létezhet, kívülről kerül átadásra
    public function __construct(private Logger $logger) {}

    public function register(string $name): void
    {
        // ... regisztrációs logika
        $this->logger->log("Új felhasználó: $name");
    }
}

$logger = new Logger();
$service = new UserService($logger);
$service->register("Kovács Anna");
