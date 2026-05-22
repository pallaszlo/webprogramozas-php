<?php

// ============================================================
// Névterek: deklarálás, use, aliasok, FQN
// Kapcsolódó fejezet: 3.10. Névterek
// ============================================================

spl_autoload_register(function (string $class): void {
    // App\Models\Student → src/Models/Student.php
    $path = __DIR__ . '/src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

// use: osztályok importálása névtérből
use App\Models\Student;
use App\Services\StudentService as Service;

// Rövidített nevek használata
$service = new Service();

$s1 = $service->register("S001", "Molnár Eszter");
$s2 = $service->register("S002", "Kovács János");

echo $s1 . PHP_EOL;  // [S001] Molnár Eszter
echo $s2 . PHP_EOL;  // [S002] Kovács János

$found = $service->find("S001");
echo "Találat: " . ($found?->getName() ?? "nem található") . PHP_EOL;

echo "Hallgatók száma: " . $service->count() . PHP_EOL;

// Teljesen minősített név (FQN) – use nélkül is működik
$s3 = new \App\Models\Student("S003", "Varga Anna");
echo $s3 . PHP_EOL;
