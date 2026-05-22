<?php

// ============================================================
// 6. feladat – applyToEach(): higher-order függvény
// ============================================================

function applyToEach(array $items, callable $fn): array
{
    $eredmeny = [];
    foreach ($items as $item) {
        $eredmeny[] = $fn($item);
    }
    return $eredmeny;
}

// 1. Névtelen függvénnyel – megduplázás
$szamok    = [1, 2, 3, 4, 5];
$dupla     = applyToEach($szamok, function(int $n): int {
    return $n * 2;
});
echo "Dupla: " . implode(", ", $dupla) . PHP_EOL;

// 2. Arrow functionnel – külső változó hozzáadása
$noveles   = 10;
$novelt    = applyToEach($szamok, fn(int $n): int => $n + $noveles);
echo "Növelt (+$noveles): " . implode(", ", $novelt) . PHP_EOL;

// 3. Beépített strtoupper() függvénnyel
$szavak    = ["alma", "korte", "szilva"];
$nagybetus = applyToEach($szavak, 'strtoupper');
echo "Nagybetűs: " . implode(", ", $nagybetus) . PHP_EOL;
