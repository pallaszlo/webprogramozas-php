<?php

// =============================================================
// 2.1. Szintaxis, változók, adattípusok
// =============================================================


// --- 2.3. Megjegyzések PHP-ben -------------------------------
// Ez egy egysoros megjegyzés
# Ez szintén egysoros megjegyzés

/*
 * Ez egy többsoros megjegyzés.
 * Több sorban is folytatható.
 */

$x = 5; // Megjegyzés sor végén is elhelyezhető


// --- 2.4. Változók deklarálása és használata -----------------
$name = "Kovács Anna";
$age = 30;
$isActive = false;

echo $name;  // Kimenet: Kovács Anna
echo $Name;  // Figyelmeztetés: Undefined variable $Name


// --- 2.5. Dinamikus típuskezelés és automatikus konverzió ----
$var = "42";
echo $var + 8;  // Kimenet: 50 (a sztring automatikusan int típussá konvertálódik)

$var = "Helló";
// $var = $var + 1;  // PHP 8-ban TypeError kivételt dob:
// a nem numerikus sztring nem alakítható számmá


// --- 2.6. Kis- és nagybetű-érzékenység példája ---------------
$name = "Kovács Anna";
$Name = "Nagy Béla";

echo $name; // Kimenet: Kovács Anna
echo $Name; // Kimenet: Nagy Béla

function greet() {
    echo "Helló!";
}

GREET(); // Működik, mert a függvénynevek nem kis- és nagybetű-érzékenyek

define("MAX_AGE", 120);

echo MAX_AGE; // Működik
// echo max_age; // PHP 8-ban Error kivételt eredményez


// --- 2.7. PHP-alaptípusok ------------------------------------
$age = 30;                           // Integer
$height = 1.78;                      // Float
$name = "Kovács Anna";               // Sztring
$isActive = true;                    // Boolean
$roles = ["admin", "user"];          // Array
$deletedAt = null;                   // NULL

class User {
    public string $name;
}

$user = new User();                  // Object

$file = fopen(__FILE__, "r");        // Resource


// --- 2.8. Konstansok definiálása -----------------------------
define("PI", 3.14);
const MAX_VALUE = 100;

echo PI;        // Kimenet: 3.14
echo MAX_VALUE; // Kimenet: 100


// --- 2.9. Különböző kiíratási módszerek ----------------------
$name = "Kovács Anna";
$age = 30;

// echo - több értéket is kiírhatunk vesszővel elválasztva
echo "Név: ", $name, ", Kor: ", $age, "<br>";

// print - csak egy értéket ír ki
print "Helló, $name!<br>";

// printf - formázott kiírás
printf("Név: %s, Kor: %d<br>", $name, $age);

// print_r - strukturált kiíratás (hasznos tömbök és objektumok esetén)
$roles = ["admin", "editor", "viewer"];
print_r($roles);

// var_dump - részletes információt ad a változóról
var_dump($name);


// --- 2.10. Típusellenőrző és típuskezelő függvények ----------
$value = "42";

// Típus ellenőrzése
var_dump(is_string($value));  // bool(true)
var_dump(is_int($value));     // bool(false)
var_dump(is_numeric($value)); // bool(true)

// Típuskonverzió
$intValue = intval($value);
var_dump($intValue); // int(42)

// Típus lekérdezése
echo gettype($value); // string

// Változó típusának beállítása
settype($value, "integer");
var_dump($value); // int(42)


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Az alaptípusok nevének lekérdezése a gettype() függvénnyel.
// Figyeljük meg, hogy a float típus neve itt "double".
$values = [30, 1.78, "Kovács Anna", true, ["admin"], null, new stdClass()];

foreach ($values as $value) {
    echo gettype($value) . PHP_EOL;
}
// Kimenet: integer, double, string, boolean, array, NULL, object

// A megnyitott erőforrást használat után zárjuk be.
$file = fopen(__FILE__, "r");
echo get_resource_type($file) . PHP_EOL;  // stream
fclose($file);
