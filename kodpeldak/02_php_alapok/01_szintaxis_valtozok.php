<?php

// ============================================================
// PHP szintaxis, változók, adattípusok, konstansok, kiíratás
// Kapcsolódó fejezet: 2.1. Szintaxis, változók, adattípusok
// ============================================================


// --- PHP kód beágyazása HTML-be --------------------------------
// Lásd: 02_syntax_variables_html.php (külön fájl a HTML példához)


// --- Változók --------------------------------------------------

$name = "Kovács Anna";
$age = 30;
$isActive = true;

echo $name;   // Kimenet: Kovács Anna
// echo $Name; // Hiba: Undefined variable (kis- és nagybetű-érzékeny)

// Dinamikus típuskezelés
$var = "42";
echo $var + 8;  // 50 – a string automatikusan int-té konvertálódik

$var = "Helló";
// PHP 8-ban TypeError kivételt dob (nem numerikus string + int nem engedélyezett):
// $var = $var + 1;


// --- Adattípusok -----------------------------------------------

$intVal    = 30;                  // integer
$floatVal  = 1.78;                // float
$strVal    = "Kovács Anna";       // string
$boolVal   = true;                // boolean
$arrVal    = ["admin", "user"];   // array
$nullVal   = null;                // NULL

class User {
    public string $name = "";
}
$userObj = new User();            // object

$file = fopen(__FILE__, "r");     // resource
fclose($file);


// --- Konstansok ------------------------------------------------

define("PI", 3.14159);
const MAX_VALUE = 100;

echo PI;         // 3.14159
echo MAX_VALUE;  // 100

// define() futási időben, const fordítási időben értékelődik ki
// const csak a legfelső szinten vagy osztályban használható


// --- Kiíratási módszerek ---------------------------------------

$roles = ["admin", "editor", "viewer"];

// echo – több értéket is fogad
echo "Név: ", $name, ", Kor: ", $age, PHP_EOL;

// print – egyetlen értéket ír ki, 1-et ad vissza
print "Helló, $name!" . PHP_EOL;

// printf – formázott kiírás közvetlenül
printf("Név: %s, Kor: %d\n", $name, $age);

// print_r – strukturált kiíratás (tömbök, objektumok)
print_r($roles);

// var_dump – típus + érték részletesen
var_dump($strVal);
var_dump($boolVal);


// --- Típusfüggvények -------------------------------------------

$value = "42";

var_dump(is_string($value));   // bool(true)
var_dump(is_int($value));      // bool(false)
var_dump(is_numeric($value));  // bool(true)

$intValue = intval($value);
var_dump($intValue);           // int(42)

echo gettype($value);          // string

settype($value, "integer");
var_dump($value);              // int(42)
