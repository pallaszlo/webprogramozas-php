<?php

// ============================================================
// 5. feladat – Osztók, darabszám, prímszám-e
// ============================================================

$szam = 36;

$osztok = [];
for ($i = 1; $i <= $szam; $i++) {
    if ($szam % $i === 0) {
        $osztok[] = $i;
    }
}

$darab   = count($osztok);
$primE   = $darab === 2;  // pontosan 2 osztója van: 1 és önmaga

echo "$szam osztói: " . implode(", ", $osztok) . PHP_EOL;
echo "Osztók száma: $darab" . PHP_EOL;
echo "$szam " . ($primE ? "prímszám" : "nem prímszám") . "." . PHP_EOL;
