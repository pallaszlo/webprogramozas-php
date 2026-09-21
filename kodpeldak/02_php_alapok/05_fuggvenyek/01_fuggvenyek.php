<?php

// =============================================================
// 2.5. Függvények
// =============================================================


// --- 2.47. Egyszerű függvénydefiníció ------------------------
function greeting($name)
{
    return "Szia, $name!";
}

echo greeting("János");  // Kimenet: Szia, János!


// --- 2.48. Eljárásszerű és függvényszerű működés -------------
function procedureExample($msg)
{
    echo $msg;
}

function functionExample($a, $b)
{
    return $a + $b;
}

procedureExample("Szia!");  // Kimenet: Szia!
$result = functionExample(3, 4);  // $result értéke: 7


// --- 2.49. Paraméterek használata ----------------------------
function greet($name, $greeting = "Szia")
{
    return "$greeting, $name!";
}

echo greet("Anna");                 // Kimenet: Szia, Anna!
echo greet("Péter", "Jó reggelt");  // Kimenet: Jó reggelt, Péter!


// --- 2.50. Alapértelmezett paraméterérték --------------------
function power($base, $exponent = 2)
{
    return $base ** $exponent;
}

echo power(3);     // Kimenet: 9 (3^2)
echo power(2, 3);  // Kimenet: 8 (2^3)


// --- 2.52. Union típusok használata --------------------------
function processInput(int|float $number): int|float
{
    return $number * 2;
}

echo processInput(5);      // 10
echo processInput(3.5);    // 7

// Több típus kombinálása
function getValue(string $key): int|string|bool|null
{
    return match ($key) {
        'count'  => 42,
        'name'   => 'PHP',
        'active' => true,
        default  => null
    };
}

// Az array típus is használható union típusban
function getData(): array|false
{
    // Sikertelen művelet esetén false értéket ad vissza
    return false;
}


// --- 2.53. Mixed típus használata ----------------------------
function processValue(mixed $value): mixed
{
    // Bármilyen típusú értéket elfogad és visszaadhat
    if (is_string($value)) {
        return strtoupper($value);
    }

    if (is_numeric($value)) {
        return $value * 2;
    }

    return $value;
}

echo processValue("szia");   // SZIA
echo processValue(5);        // 10
print_r(processValue([1, 2]));


// --- 2.55. Visszatérési érték típusa -------------------------
function getName(): string
{
    return "János";
}

$name = getName();
var_dump($name);  // string(6) "János"


// --- 2.57. Referencia szerinti paraméterátadás ---------------
function increment(&$number)
{
    $number++;
}

$a = 5;
increment($a);

echo $a;  // Kimenet: 6


// --- 2.58. Név szerinti argumentumok használata --------------
function createUser(
    string $name,
    string $email,
    int $age = 18,
    bool $active = true
) {
    // ...
}

// Hagyományos hívás
createUser("Kovács János", "kovacs.janos@example.com", 25, false);

// Named arguments használata
createUser(
    name: "Kovács János",
    email: "kovacs.janos@example.com",
    age: 25,
    active: false
);

// Csak a kötelező paraméterek megadása
createUser(
    name: "Nagy Péter",
    email: "nagy.peter@example.com"
);


// --- 2.59. Lokális változók ----------------------------------
function showMessage()
{
    $message = "Helló a függvényből!";  // lokális változó
    echo $message;
}

showMessage();   // Kimenet: Helló a függvényből!
echo $message;   // Warning: Undefined variable $message


// --- 2.60. Statikus változók ---------------------------------
function counter()
{
    static $count = 0;
    return ++$count;
}

echo counter();  // Kimenet: 1
echo counter();  // Kimenet: 2
echo counter();  // Kimenet: 3


// --- 2.61. Névtelen függvény változóhoz rendelve -------------
$greet = function ($name) {
    return "Helló, $name!";
};

echo $greet("Anna");  // Kimenet: Helló, Anna!


// --- 2.62. Névtelen függvény callbackként --------------------
$numbers = [1, 2, 3, 4, 5];
$evens = array_filter($numbers, function ($n) {
    return $n % 2 == 0;
});
print_r($evens);  // Array ( [1] => 2 [3] => 4 )


// --- 2.63. Closure példa -------------------------------------
$message = 'Helló';

$greet = function () use ($message) {
    echo $message;
};

$greet(); // Kimenet: Helló


// --- 2.64. Closure paraméterekkel ----------------------------
$multiplier = 2;

$multiply = function ($value) use ($multiplier) {
    return $value * $multiplier;
};

echo $multiply(5); // Kimenet: 10


// --- 2.65. Nyílfüggvény példa --------------------------------
$message = 'Szia';

$greet = fn($name) => $message . ', ' . $name;

echo $greet('világ'); // Kimenet: Szia, világ


// --- 2.66. Nyílfüggvény callback függvényként ----------------
$numbers = [1, 2, 3, 4, 5];
$multiplier = 2;

$doubled = array_map(fn($n) => $n * $multiplier, $numbers);

print_r($doubled);
// Array ( [0] => 2 [1] => 4 [2] => 6 [3] => 8 [4] => 10 )

// Összehasonlítás hagyományos closure szintaxissal:
$doubledClosure = array_map(function($n) use ($multiplier)
{
    return $n * $multiplier;
}, $numbers);


// --- 2.67. Egyszerű variadic függvény ------------------------
function sum(...$numbers)
{
    return array_sum($numbers);
}

echo sum(1, 2, 3, 4);  // Kimenet: 10
echo sum(5, 10, 15);   // Kimenet: 30


// --- 2.68. Variadic függvény sztringek összefűzésére ---------
function concatenate(...$strings)
{
    return implode(', ', $strings);
}

echo concatenate('alma', 'banán', 'citrom');
// Kimenet: alma, banán, citrom

echo concatenate('egy', 'kettő');
// Kimenet: egy, kettő


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// void visszatérési típus: a függvény nem ad vissza értéket
function printSeparator(): void
{
    echo str_repeat("-", 40) . PHP_EOL;
}
printSeparator();

// float|false: sikertelen művelet esetén false a visszatérési érték
function divide(float $a, float $b): float|false
{
    if ($b === 0.0) {
        return false;
    }
    return $a / $b;
}
var_dump(divide(10, 4));  // float(2.5)
var_dump(divide(10, 0));  // bool(false)

// Név szerinti argumentumok tetszőleges sorrendben,
// illetve pozíció szerinti argumentumokkal vegyesen
function makeUserLabel(string $name, int $age, string $role = "user"): string
{
    return "$name ($age) – $role";
}
echo makeUserLabel(age: 25, name: "Kovács Anna") . PHP_EOL;     // Kovács Anna (25) – user
echo makeUserLabel("Nagy Béla", age: 30, role: "admin") . PHP_EOL; // Nagy Béla (30) – admin

// use referenciával: a closure módosíthatja a külső változót
$total = 0;
$addToTotal = function (int $amount) use (&$total): void {
    $total += $amount;
};
$addToTotal(10);
$addToTotal(25);
echo $total . PHP_EOL;  // 35

// Kötelező paraméter és változó számú paraméter együtt
function logMessage(string $level, string ...$messages): void
{
    foreach ($messages as $msg) {
        echo "[$level] $msg" . PHP_EOL;
    }
}
logMessage("INFO", "Indulás", "Kapcsolat létrejött", "Kész");
// [INFO] Indulás
// [INFO] Kapcsolat létrejött
// [INFO] Kész
