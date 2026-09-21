<?php

// ============================================================
// 2. feladat – Webáruház konfiguráció ?? operátorral
// ============================================================

// Részleges konfiguráció (timeout és max_items hiányzik)
$config = [
    'currency' => 'EUR',
];

// ?? – alapértékek beállítása, ha a kulcs hiányzik
$config['timeout']   = $config['timeout']   ?? 30;
$config['currency']  = $config['currency']  ?? 'RON';
$config['max_items'] = $config['max_items'] ?? 100;

// ??= – debug kulcs hozzáadása, ha még nem létezik
$config['debug'] ??= false;

echo "Konfiguráció:" . PHP_EOL;
foreach ($config as $kulcs => $ertek) {
    $ertekStr = is_bool($ertek) ? ($ertek ? 'true' : 'false') : $ertek;
    printf("  %-12s → %s\n", $kulcs, $ertekStr);
}
