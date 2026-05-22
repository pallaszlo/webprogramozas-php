<?php

// ============================================================
// Operátorok: aritmetikai, hozzárendelő, logikai,
//             összehasonlító, ternáris, null coalescing, spaceship
// Kapcsolódó fejezet: 2.3. Operátorok
// ============================================================


// --- Aritmetikai operátorok ------------------------------------

$a = 10;
$b = 3;

echo $a + $b  . PHP_EOL;  // 13
echo $a - $b  . PHP_EOL;  // 7
echo $a * $b  . PHP_EOL;  // 30
echo $a / $b  . PHP_EOL;  // 3.333...
echo $a % $b  . PHP_EOL;  // 1  (maradék)
echo $a ** $b . PHP_EOL;  // 1000 (10 a harmadikon)


// --- Hozzárendelő operátorok -----------------------------------

$x = 5;
$x += 3;   echo $x . PHP_EOL;  // 8
$x -= 2;   echo $x . PHP_EOL;  // 6
$x *= 4;   echo $x . PHP_EOL;  // 24
$x /= 6;   echo $x . PHP_EOL;  // 4
$x %= 3;   echo $x . PHP_EOL;  // 1

$str  = "Helló";
$str .= " Világ";
echo $str . PHP_EOL;  // Helló Világ


// --- Logikai operátorok ----------------------------------------

$t = true;
$f = false;

var_dump($t && $f);  // bool(false)
var_dump($t || $f);  // bool(true)
var_dump(!$t);       // bool(false)


// --- Összehasonlító operátorok ---------------------------------

$num = 5;
$str = "5";

// == értéket hasonlít, típust NEM
var_dump($num == $str);   // bool(true)

// === értéket ÉS típust is hasonlít – általában ezt használjuk
var_dump($num === $str);  // bool(false)
var_dump($num === 5);     // bool(true)

var_dump($num != "6");    // bool(true)
var_dump($num !== 5);     // bool(false)
var_dump(3 < 5);          // bool(true)
var_dump(5 >= 5);         // bool(true)


// --- empty(), isset(), is_null() -------------------------------

$emptyStr = "";
$zero     = 0;
$null     = null;
$text     = "Helló";

// empty() – üres string, 0, false, null → true
var_dump(empty($emptyStr));  // true
var_dump(empty($zero));      // true
var_dump(empty($text));      // false

// is_null() – csak null értékre ad true-t
var_dump(is_null($null));    // true
var_dump(is_null($emptyStr)); // false

// isset() – false ha null vagy nem létezik, true ha be van állítva
var_dump(isset($text));      // true
var_dump(isset($null));      // false
var_dump(isset($undefined)); // false


// --- Ternáris operátor -----------------------------------------

$age    = 20;
$status = $age >= 18 ? "felnőtt" : "kiskorú";
echo $status . PHP_EOL;  // felnőtt

// Rövidített ternáris: ha $value nem üres/false, azt adja vissza
$value   = "";
$display = $value ?: "alapértelmezett";
echo $display . PHP_EOL;  // alapértelmezett


// --- Null coalescing operátor (??) -----------------------------

// Ha a bal oldal null vagy nem létezik, a jobb oldalt adja vissza
$username = $_GET['user'] ?? "vendég";
echo $username . PHP_EOL;  // vendég (ha nincs GET paraméter)

// Láncolható
$config = null;
$host   = $config['db']['host'] ?? $_ENV['DB_HOST'] ?? 'localhost';
echo $host . PHP_EOL;  // localhost


// --- Spaceship operátor (<=>)  ---------------------------------
// -1 ha bal < jobb, 0 ha egyenlő, 1 ha bal > jobb

echo (1 <=> 2)   . PHP_EOL;  // -1
echo (2 <=> 2)   . PHP_EOL;  //  0
echo (3 <=> 2)   . PHP_EOL;  //  1
echo ("a" <=> "b") . PHP_EOL; // -1

// Tipikus használat: usort callback
$numbers = [3, 1, 4, 1, 5, 9, 2];
usort($numbers, fn($a, $b) => $a <=> $b);
print_r($numbers);  // [1, 1, 2, 3, 4, 5, 9]
