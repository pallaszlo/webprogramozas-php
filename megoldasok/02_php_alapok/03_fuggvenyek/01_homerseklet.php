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
    ["Testhőmérséklet", 36.6],
    ["Forráspont",      100.0],
];

// A printf() a szöveg hosszát bájtokban számolja, nem karakterekben.
// Ezért az ékezetes szövegeket karakterszám alapján egészítjük ki szóközökkel.
function kitolt(string $szoveg, int $szelesseg): string
{
    return $szoveg . str_repeat(' ', max(0, $szelesseg - mb_strlen($szoveg)));
}

printf("%s %8s %8s %8s\n", kitolt("Eset", 18), "C", "F", "K");
printf("%s\n", str_repeat("-", 46));

foreach ($esetek as [$nev, $celsius]) {
    printf(
        "%s %8.2f %8.2f %8.2f\n",
        kitolt($nev, 18),
        $celsius,
        celsiusToFahrenheit($celsius),
        celsiusToKelvin($celsius)
    );
}

echo PHP_EOL;

// Fahrenheit → Celsius visszaellenőrzés
$fahrenheit = 98.6;
printf("%.1f°F = %.2f°C\n", $fahrenheit, fahrenheitToCelsius($fahrenheit));
