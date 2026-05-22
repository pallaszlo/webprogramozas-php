<?php

// ============================================================
// 1. feladat – Hőmérsékleti skálák közötti átváltás
// ============================================================

function celsiusToFahrenheit(float $celsius): float
{
    return $celsius * 9 / 5 + 32;
}

function celsiusToKelvin(float $celsius): float
{
    return $celsius + 273.15;
}

function fahrenheitToCelsius(float $fahrenheit): float
{
    return ($fahrenheit - 32) * 5 / 9;
}

// Jellegzetes értékek
$esetek = [
    ["Fagypont",        0.0],
    ["Testhomerseklet", 36.6],
    ["Forraspot",       100.0],
];

printf("%-18s %8s %8s %8s\n", "Eset", "C", "F", "K");
printf("%s\n", str_repeat("-", 46));

foreach ($esetek as [$nev, $celsius]) {
    printf(
        "%-18s %8.2f %8.2f %8.2f\n",
        $nev,
        $celsius,
        celsiusToFahrenheit($celsius),
        celsiusToKelvin($celsius)
    );
}

echo PHP_EOL;

// Fahrenheit → Celsius visszaellenőrzés
$fahrenheit = 98.6;
printf("%.1f°F = %.2f°C\n", $fahrenheit, fahrenheitToCelsius($fahrenheit));
