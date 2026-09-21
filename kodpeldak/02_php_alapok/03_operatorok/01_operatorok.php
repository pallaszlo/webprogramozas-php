<?php

// =============================================================
// 2.3. Operátorok
// =============================================================


// --- 2.16. Hozzárendelő operátorok használata ----------------
$a = 5;
$a += 3; // Ekvivalens: $a = $a + 3;
echo $a; // Kimenet: 8

$str = "Helló";
$str .= " világ"; // karakterlánc összefűzés és hozzárendelés
echo $str; // Kimenet: "Helló világ"


// --- 2.17. Logikai operátorok használata ---------------------
$a = true;
$b = false;

var_dump($a && $b); // Kimenet: bool(false)
var_dump($a || $b); // Kimenet: bool(true)
var_dump(!$a);      // Kimenet: bool(false)


// --- 2.18. Összehasonlító operátorok használata --------------
$a = 5;
$b = "5";

var_dump($a == $b);  // Kimenet: bool(true)  - az érték egyezik
var_dump($a === $b); // Kimenet: bool(false) - a típus különbözik
var_dump($a != "6"); // Kimenet: bool(true)
var_dump($a !== 5);  // Kimenet: bool(false)


// --- 2.19. Változók ellenőrzésének használata ----------------
$emptyString = "";
$nullValue = null;
$zeroInt = 0;
$falseBool = false;
$nonEmptyString = "Helló";

// empty() függvény
var_dump(empty($emptyString));    // bool(true)
var_dump(empty($nullValue));      // bool(true)
var_dump(empty($zeroInt));        // bool(true)
var_dump(empty($falseBool));      // bool(true)
var_dump(empty($nonEmptyString)); // bool(false)

// is_null() függvény
var_dump(is_null($emptyString));  // bool(false)
var_dump(is_null($nullValue));    // bool(true)
var_dump(is_null($zeroInt));      // bool(false)

// isset() függvény
var_dump(isset($emptyString));    // bool(true)
var_dump(isset($nullValue));      // bool(false)
var_dump(isset($undefinedVar));   // bool(false)


// --- 2.20. Feltételes operátor használata --------------------
$age = 20;
$status = ($age >= 18) ? "felnőtt" : "kiskorú";

echo $status; // Kimenet: "felnőtt"

// Egymásba ágyazott használat (kerülendő)
$result = $a > $b ? "a nagyobb" : ($a < $b ? "b nagyobb" : "egyenlőek");


// --- 2.21. Null coalescing operátor használata ---------------
$name = $firstName ?? "Névtelen";

echo $name;
// Ha $firstName nem létezik vagy null, "Névtelen" lesz kiírva

// Ekvivalens megoldás:
$name = isset($firstName) ? $firstName : "Névtelen";

// Láncolható: több forrásból az első nem null értéket választja
$username = $_GET['user'] ?? $_POST['user'] ?? 'vendeg';

$data = $result['data'] ?? [];


// --- 2.22. A ??= operátor használata -------------------------
$config['debug'] ??= false;
// Ekvivalens: $config['debug'] = $config['debug'] ?? false;


// --- 2.23. Spaceship operátor használata ---------------------
echo 1 <=> 1; // Kimenet: 0  (egyenlő)
echo 1 <=> 2; // Kimenet: -1 (bal oldal kisebb)
echo 2 <=> 1; // Kimenet: 1  (bal oldal nagyobb)

// Használat rendezésnél
$fruits = ['alma', 'körte', 'szilva'];

usort($fruits, function ($a, $b) {
    return $a <=> $b;
});

print_r($fruits);
// Kimenet: Array ( [0] => alma [1] => körte [2] => szilva )


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Aritmetikai operátorok (a 2.1. táblázat műveletei)
$a = 10;
$b = 3;

echo $a + $b . PHP_EOL;   // 13
echo $a - $b . PHP_EOL;   // 7
echo $a * $b . PHP_EOL;   // 30
echo $a / $b . PHP_EOL;   // 3.3333333333333
echo $a % $b . PHP_EOL;   // 1 (maradék)
echo $a ** $b . PHP_EOL;  // 1000 (10 a harmadikon)

// További összetett hozzárendelő operátorok
$x = 5;
$x += 3;  echo $x . PHP_EOL;  // 8
$x -= 2;  echo $x . PHP_EOL;  // 6
$x *= 4;  echo $x . PHP_EOL;  // 24
$x /= 6;  echo $x . PHP_EOL;  // 4
$x %= 3;  echo $x . PHP_EOL;  // 1

// Rövidített feltételes operátor (?:)
// Ha a bal oldal üres vagy hamis, a jobb oldalt adja vissza.
$value = "";
$display = $value ?: "alapértelmezett";
echo $display . PHP_EOL;  // alapértelmezett

// Láncolt ?? többszintű tömbön
$config = null;
$host = $config['db']['host'] ?? 'localhost';
echo $host . PHP_EOL;  // localhost

// A spaceship operátor sztringekre is működik
echo ("a" <=> "b") . PHP_EOL;  // -1
