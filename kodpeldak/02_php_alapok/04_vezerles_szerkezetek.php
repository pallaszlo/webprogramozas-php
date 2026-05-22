<?php

// ============================================================
// Vezérlési szerkezetek: if/elseif/else, switch, match,
//                        while, do-while, for, foreach, break/continue
// Kapcsolódó fejezet: 2.4. Vezérlési szerkezetek
// ============================================================


// --- if / elseif / else ----------------------------------------

$age = 18;
if ($age >= 18) {
    echo "Felnőtt." . PHP_EOL;
}

$balance    = 1000;
$withdrawal = 1200;
if ($balance >= $withdrawal) {
    echo "Sikeres tranzakció." . PHP_EOL;
    $balance -= $withdrawal;
} else {
    echo "Nincs elég fedezet." . PHP_EOL;
}

$grade = 75;
if ($grade >= 90) {
    echo "Jeles" . PHP_EOL;
} elseif ($grade >= 80) {
    echo "Jó" . PHP_EOL;
} elseif ($grade >= 70) {
    echo "Közepes" . PHP_EOL;
} elseif ($grade >= 60) {
    echo "Elégséges" . PHP_EOL;
} else {
    echo "Elégtelen" . PHP_EOL;
}


// --- switch ----------------------------------------------------

$day = "hétfő";
switch ($day) {
    case "hétfő":
    case "kedd":
    case "szerda":
    case "csütörtök":
    case "péntek":
        echo "Hétköznap" . PHP_EOL;
        break;
    case "szombat":
    case "vasárnap":
        echo "Hétvége" . PHP_EOL;
        break;
    default:
        echo "Ismeretlen nap" . PHP_EOL;
}


// --- match (PHP 8.0+) ------------------------------------------
// Szigorú összehasonlítás (===), nem esik át a következő case-re

$status = 2;
$label  = match($status) {
    1       => "Aktív",
    2, 3    => "Függőben",
    4       => "Lezárva",
    default => "Ismeretlen",
};
echo $label . PHP_EOL;  // Függőben

// match értéket ad vissza, nem szükséges break


// --- while -----------------------------------------------------

$i = 1;
while ($i <= 5) {
    echo $i . " ";
    $i++;
}
echo PHP_EOL;  // 1 2 3 4 5


// --- do...while (legalább egyszer lefut) -----------------------

$n = 10;
do {
    echo $n . " ";
    $n++;
} while ($n <= 5);
echo PHP_EOL;  // 10  (egyszer lefut, mert az ellenőrzés utólag van)


// --- for -------------------------------------------------------

for ($j = 0; $j < 5; $j++) {
    echo $j . " ";
}
echo PHP_EOL;  // 0 1 2 3 4

// Visszafelé
for ($k = 5; $k > 0; $k--) {
    echo $k . " ";
}
echo PHP_EOL;  // 5 4 3 2 1


// --- foreach ---------------------------------------------------

$fruits = ["alma", "körte", "szilva"];
foreach ($fruits as $fruit) {
    echo $fruit . PHP_EOL;
}

// Indexelt tömb – kulcs és érték
$prices = [1200, 350, 89, 4500, 275];
$total = 0;
foreach ($prices as $index => $price) {
    echo ($index + 1) . ". termék ára: $price RON\n";
    $total += $price;
}
echo "Összesen: $total RON" . PHP_EOL;

// Asszociatív tömb bejárása
$person = ["name" => "Kovács Anna", "age" => 30, "city" => "Kolozsvár"];
foreach ($person as $key => $value) {
    echo "$key: $value" . PHP_EOL;
}


// --- break és continue -----------------------------------------

// break kilép a ciklusból
for ($m = 0; $m < 10; $m++) {
    if ($m === 5) break;
    echo $m . " ";
}
echo PHP_EOL;  // 0 1 2 3 4

// continue átugorja az aktuális iterációt
for ($p = 0; $p < 10; $p++) {
    if ($p % 2 === 0) continue;
    echo $p . " ";
}
echo PHP_EOL;  // 1 3 5 7 9


// --- Egymásba ágyazott ciklusok --------------------------------

for ($row = 1; $row <= 3; $row++) {
    for ($col = 1; $col <= 3; $col++) {
        echo "{$row}×{$col}=" . ($row * $col) . "  ";
    }
    echo PHP_EOL;
}

// Foreach egymásba ágyazva
$students = ["Anna", "Béla", "Csilla"];
$subjects = ["Webprogramozás", "Adatbázisok", "Algoritmusok"];

foreach ($students as $student) {
    foreach ($subjects as $subject) {
        echo "$student - $subject\n";
    }
}
