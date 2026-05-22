<?php

// ============================================================
// Függvények: alapok, paraméterek, típusok, hatókör,
//             névtelen, closure, arrow function, variadic
// Kapcsolódó fejezet: 2.5. Függvények
// ============================================================


// --- Alapvető függvény -----------------------------------------

function greeting(string $name): string
{
    return "Szia, $name!";
}
echo greeting("János") . PHP_EOL;  // Szia, János!


// --- Eljárás (nincs visszatérési érték) ------------------------

function printSeparator(): void
{
    echo str_repeat("-", 40) . PHP_EOL;
}
printSeparator();


// --- Alapértelmezett paraméter ---------------------------------

function greet(string $name, string $greeting = "Szia"): string
{
    return "$greeting, $name!";
}
echo greet("Anna") . PHP_EOL;                   // Szia, Anna!
echo greet("Péter", "Jó reggelt") . PHP_EOL;    // Jó reggelt, Péter!


// --- Type hinting és visszatérési típus ------------------------

function add(int $a, int $b): int
{
    return $a + $b;
}
echo add(5, 3) . PHP_EOL;  // 8

function divide(float $a, float $b): float|false
{
    if ($b === 0.0) return false;
    return $a / $b;
}
var_dump(divide(10, 3));   // float(3.333...)
var_dump(divide(10, 0));   // bool(false)


// --- Named arguments (PHP 8.0+) --------------------------------

function createUser(string $name, int $age, string $role = "user"): string
{
    return "$name ($age) – $role";
}
echo createUser(age: 25, name: "Kovács Anna") . PHP_EOL;
echo createUser("Nagy Béla", age: 30, role: "admin") . PHP_EOL;


// --- Referencia szerinti paraméter átadás ----------------------

function increment(int &$value): void
{
    $value++;
}
$counter = 5;
increment($counter);
echo $counter . PHP_EOL;  // 6


// --- Változók hatóköre -----------------------------------------

$globalVar = "globális";

function scopeDemo(): void
{
    // $globalVar nem elérhető itt alapból
    // echo $globalVar;  // Figyelmeztetés: Undefined variable

    global $globalVar;  // explicit import szükséges
    echo $globalVar . PHP_EOL;
}
scopeDemo();

// Statikus változó: megőrzi értékét hívások között
function counter(): void
{
    static $count = 0;
    $count++;
    echo "Hívás: $count" . PHP_EOL;
}
counter();  // Hívás: 1
counter();  // Hívás: 2
counter();  // Hívás: 3


// --- Névtelen függvény (anonymous function) --------------------

$multiply = function(int $a, int $b): int {
    return $a * $b;
};
echo $multiply(4, 5) . PHP_EOL;  // 20

// Átadható más függvénynek
$numbers = [3, 1, 4, 1, 5, 9];
usort($numbers, function($a, $b) { return $a - $b; });
print_r($numbers);


// --- Closure (use – külső változó befogása) --------------------

$prefix = "Helló";
$greetFn = function(string $name) use ($prefix): string {
    return "$prefix, $name!";
};
echo $greetFn("Világ") . PHP_EOL;  // Helló, Világ!

// use referenciával – a módosítás visszahat a külső változóra
$total = 0;
$addToTotal = function(int $amount) use (&$total): void {
    $total += $amount;
};
$addToTotal(10);
$addToTotal(25);
echo $total . PHP_EOL;  // 35


// --- Arrow function (PHP 7.4+) ---------------------------------
// Automatikusan befogja a külső változókat, tömörebb szintaxis

$factor = 3;
$triple = fn(int $n): int => $n * $factor;
echo $triple(7) . PHP_EOL;  // 21

$prices = [100, 200, 350];
$discounted = array_map(fn($p) => $p * 0.9, $prices);
print_r($discounted);  // Array ( [0] => 90 [1] => 180 [2] => 315 )


// --- Variadic függvény (tetszőleges számú paraméter) -----------

function sum(int ...$numbers): int
{
    return array_sum($numbers);
}
echo sum(1, 2, 3) . PHP_EOL;       // 6
echo sum(1, 2, 3, 4, 5) . PHP_EOL; // 15

// Vegyes paraméter: kötelező + variadic
function logMessage(string $level, string ...$messages): void
{
    foreach ($messages as $msg) {
        echo "[$level] $msg" . PHP_EOL;
    }
}
logMessage("INFO", "Indulás", "Kapcsolat létrejött", "Kész");
