<?php

// ============================================================
// Tömbök: indexelt, asszociatív, bejárás, rendezés,
//         array_map/filter/walk, többdimenziós
// Kapcsolódó fejezet: 2.6. Tömbök
// ============================================================


// --- Indexelt tömb ---------------------------------------------

$fruits = ["alma", "körte", "szilva"];

echo $fruits[0] . PHP_EOL;  // alma
echo count($fruits) . PHP_EOL;  // 3

// Hozzáadás
$fruits[] = "barack";
array_push($fruits, "meggy");

// Elem törlése (az indexek megmaradnak!)
unset($fruits[1]);
print_r($fruits);

// Tömbök összefűzése
$a = [1, 2, 3];
$b = [4, 5, 6];
$merged = array_merge($a, $b);
print_r($merged);


// --- Asszociatív tömb ------------------------------------------

$person = [
    "name"  => "Kovács Anna",
    "age"   => 30,
    "email" => "anna@example.ro",
];

echo $person["name"] . PHP_EOL;  // Kovács Anna

// Módosítás, hozzáadás, törlés
$person["age"]  = 31;
$person["city"] = "Kolozsvár";
unset($person["email"]);

print_r($person);

// Kulcs meglétének ellenőrzése
if (array_key_exists("city", $person)) {
    echo "Van city mező." . PHP_EOL;
}


// --- Tömbök bejárása -------------------------------------------

foreach ($fruits as $fruit) {
    echo $fruit . PHP_EOL;
}

foreach ($person as $key => $value) {
    echo "$key: $value" . PHP_EOL;
}


// --- Hasznos tömbfüggvények ------------------------------------

$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5];

echo (in_array(5, $numbers) ? "Megtalálva" : "Nincs") . PHP_EOL;
echo array_search(4, $numbers) . PHP_EOL;  // 2 (index)
echo implode(", ", $numbers)   . PHP_EOL;

$sliced  = array_slice($numbers, 2, 4);   // 4 elem, index 2-től
$unique  = array_unique($numbers);         // duplikátumok eltávolítása
$flipped = array_flip(["a" => 1, "b" => 2]);  // kulcs és érték felcserélése

print_r($unique);
print_r($flipped);


// --- Rendezés --------------------------------------------------

$names = ["Zoltán", "Anna", "Béla", "Csilla"];

sort($names);       // Értékek szerint növekvő (index újraszámozódik)
print_r($names);

$scores = ["Anna" => 95, "Béla" => 87, "Csilla" => 92];

arsort($scores);    // Értékek szerint csökkenő, kulcsok megmaradnak
print_r($scores);

ksort($scores);     // Kulcsok szerint növekvő
print_r($scores);

// Egyedi rendezés usort-tal
$products = [
    ["name" => "Laptop",  "price" => 1200],
    ["name" => "Monitor", "price" => 350],
    ["name" => "Egér",    "price" => 25],
];
usort($products, fn($a, $b) => $a["price"] <=> $b["price"]);
print_r($products);  // ár szerint növekvő


// --- array_map, array_filter, array_walk -----------------------

$prices = [100, 200, 300, 400];

// array_map – minden elemre alkalmaz egy függvényt, visszaadja az új tömböt
$discounted = array_map(fn($p) => $p * 0.8, $prices);
print_r($discounted);

// array_filter – csak azokat tartja meg, amelyekre igaz a feltétel
$expensive = array_filter($prices, fn($p) => $p > 150);
print_r($expensive);

// array_walk – módosítja az eredeti tömböt (referencia szerinti)
$labels = ["alma", "korte", "szilva"];
array_walk($labels, function(&$item, $key) {
    $item = "$key: " . strtoupper($item);
});
print_r($labels);


// --- Többdimenziós tömb ----------------------------------------

$students = [
    ["name" => "Kovács Anna",  "grade" => 95],
    ["name" => "Nagy Béla",    "grade" => 78],
    ["name" => "Tóth Csilla",  "grade" => 88],
];

foreach ($students as $student) {
    echo "{$student['name']}: {$student['grade']}" . PHP_EOL;
}

// Rendezés jegy szerint csökkenő
usort($students, fn($a, $b) => $b["grade"] <=> $a["grade"]);
echo "Legjobb: " . $students[0]["name"] . PHP_EOL;
