<?php

// =============================================================
// 2.6. Tömbök
// =============================================================


// --- 2.70. Indexelt tömb létrehozása -------------------------
$fruits = ["alma", "banán", "cseresznye"];

// Régebbi szintaxis (kerülendő)
$vegetables = array("sárgarépa", "brokkoli", "spenót");

// Üres tömb létrehozása és elemek hozzáadása
$colors = [];
$colors[] = "piros";
$colors[] = "zöld";
$colors[] = "kék";


// --- 2.71. Indexelt tömb elemeinek elérése -------------------
echo $fruits[0];      // Kimenet: alma
echo $vegetables[1];  // Kimenet: brokkoli


// --- 2.72. Biztonságos elemhozzáférés ------------------------
if (isset($fruits[3])) {
    echo $fruits[3];
} else {
    echo "A negyedik elem nem létezik.";
}


// --- 2.73. Tömb elemeinek törlése unset() függvénnyel --------
$fruits = ["alma", "banán", "cseresznye", "datolya"];
unset($fruits[1]);  // törli a "banán" elemet

print_r($fruits);
// Kimenet:
// Array
// (
//     [0] => alma
//     [2] => cseresznye
//     [3] => datolya
// )


// --- 2.74. Tömb újraindexelése törlés után -------------------
$fruits = ["alma", "banán", "cseresznye", "datolya"];
unset($fruits[1]);

$fruits = array_values($fruits);  // újraindexelés

print_r($fruits);
// Kimenet:
// Array
// (
//     [0] => alma
//     [1] => cseresznye
//     [2] => datolya
// )


// --- 2.75. Asszociatív tömbök létrehozása --------------------
$person = [
    "name" => "Kovács János",
    "age" => 30,
    "city" => "Budapest"
];

$car = [
    "brand" => "Toyota",
    "model" => "Corolla",
    "year" => 2020
];


// --- 2.76. Asszociatív tömb elemeinek elérése ----------------
echo $person["name"];  // Kimenet: Kovács János
echo $car["brand"];    // Kimenet: Toyota


// --- 2.77. Biztonságos elemhozzáférés asszociatív tömbben ----
if (array_key_exists("age", $person)) {
    echo "Kor: " . $person["age"];
} else {
    echo "Kor nincs megadva.";
}


// --- 2.78. Indexelt tömb bejárása ----------------------------
// for ciklussal
for ($i = 0; $i < count($fruits); $i++) {
    echo $fruits[$i] . "<br>";
}

// foreach ciklussal
foreach ($fruits as $fruit) {
    echo $fruit . "<br>";
}


// --- 2.79. Asszociatív tömb bejárása -------------------------
foreach ($person as $key => $value) {
    echo "$key: $value<br>";
}


// --- 2.80. Tömbök rendezése ----------------------------------
$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5];
sort($numbers);

print_r($numbers);
// Kimenet:
// Array ( [0] => 1 [1] => 1 [2] => 2 [3] => 3 [4] => 3 [5] => 4 [6] => 5 [7] => 5 [8] => 5 [9] => 6 [10] => 9 )

$fruits = ["banán" => "sárga", "alma" => "piros", "cseresznye" => "piros"];
asort($fruits);

print_r($fruits);
// Kimenet:
// Array ( [alma] => piros [cseresznye] => piros [banán] => sárga )


// --- 2.81. array_map() használata ----------------------------
$numbers = [1, 2, 3, 4, 5];

$squared = array_map(function($n) {
    return $n * $n;
}, $numbers);

print_r($squared);
// Kimenet:
// Array ( [0] => 1 [1] => 4 [2] => 9 [3] => 16 [4] => 25 )


// --- 2.82. array_walk() használata ---------------------------
$fruits = ["a" => "alma", "b" => "banán"];

array_walk($fruits, function(&$value, $key) {
    $value = mb_strtoupper($value);
});

print_r($fruits);
// Kimenet:
// Array ( [a] => ALMA [b] => BANÁN )


// --- 2.83. array_filter() használata -------------------------
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$even = array_filter($numbers, function($n) {
    return $n % 2 == 0;
});

print_r($even);
// Kimenet:
// Array ( [1] => 2 [3] => 4 [5] => 6 [7] => 8 [9] => 10 )


// --- 2.84. Többdimenziós tömb --------------------------------
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

echo $matrix[1][2];  // Kimenet: 6

$users = [
    ["name" => "János", "age" => 30],
    ["name" => "Anna",  "age" => 25]
];

echo $users[1]["name"];  // Kimenet: Anna


// --- 2.85. Többdimenziós tömb bejárása -----------------------
foreach ($users as $user) {
    foreach ($user as $key => $value) {
        echo "$key: $value<br>";
    }

    echo "<br>";
}


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Elemek hozzáadása és tömbök összefűzése
$fruits = ["alma", "körte", "szilva"];
$fruits[] = "barack";
array_push($fruits, "meggy");
echo count($fruits) . PHP_EOL;  // 5

$merged = array_merge([1, 2, 3], [4, 5, 6]);
echo implode(", ", $merged) . PHP_EOL;  // 1, 2, 3, 4, 5, 6

// Keresés és részek kiemelése
$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5];

echo (in_array(5, $numbers) ? "Megtalálva" : "Nincs") . PHP_EOL;  // Megtalálva
echo array_search(4, $numbers) . PHP_EOL;                        // 2 (az index)
echo implode(", ", array_slice($numbers, 2, 4)) . PHP_EOL;       // 4, 1, 5, 9
echo implode(", ", array_unique($numbers)) . PHP_EOL;            // 3, 1, 4, 5, 9, 2, 6

// Kulcsok és értékek felcserélése
print_r(array_flip(["a" => 1, "b" => 2]));  // Array ( [1] => a [2] => b )

// Asszociatív tömb rendezése érték (arsort) és kulcs (ksort) szerint
$scores = ["Béla" => 87, "Anna" => 95, "Csilla" => 92];

arsort($scores);
print_r($scores);  // Anna 95, Csilla 92, Béla 87

ksort($scores);
print_r($scores);  // Anna, Béla, Csilla

// Többdimenziós tömb rendezése egy mező szerint
$products = [
    ["name" => "Laptop",  "price" => 1200],
    ["name" => "Monitor", "price" => 350],
    ["name" => "Egér",    "price" => 25],
];
usort($products, fn($a, $b) => $a["price"] <=> $b["price"]);
echo implode(", ", array_column($products, "name")) . PHP_EOL;  // Egér, Monitor, Laptop
