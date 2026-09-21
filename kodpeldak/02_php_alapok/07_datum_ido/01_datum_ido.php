<?php

// =============================================================
// 2.7. Dátum- és időkezelés
// =============================================================


// --- 2.86. Aktuális dátum és idő lekérdezése -----------------
echo date("Y-m-d H:i:s");  // pl. 2025-05-15 14:30:00
echo time();               // UNIX-időbélyeg, pl. 1747308600


// --- 2.87. Időzóna beállítása --------------------------------
date_default_timezone_set('Europe/Bucharest');


// --- 2.88. Dátum formázása különböző módokon -----------------
$timestamp = time();

echo date("Y. F j., l", $timestamp);  // pl. 2025. May 15., Thursday
echo date("Y-m-d", $timestamp);       // pl. 2025-05-15
echo date("d/m/Y H:i", $timestamp);   // pl. 15/05/2025 14:30
echo date("j. n. Y", $timestamp);     // pl. 15. 5. 2025


// --- 2.89. Dátum formázása magyar nyelven --------------------
$formatter = new IntlDateFormatter(
    'hu_HU',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE
);
echo $formatter->format(time());  // pl. 2025. május 15., csütörtök


// --- 2.90. Dátum létrehozása és módosítása -------------------
$date = strtotime("2025-05-15 14:30:00");
echo date("Y-m-d H:i:s", $date);  // 2025-05-15 14:30:00

$nextWeek = strtotime("+1 week", $date);
echo date("Y-m-d H:i:s", $nextWeek);  // 2025-05-22 14:30:00

$lastDayOfMonth = strtotime("last day of May 2025");
echo date("Y-m-d", $lastDayOfMonth);  // 2025-05-31

$nextTuesday = strtotime("next Tuesday");
echo date("Y-m-d", $nextTuesday);  // következő kedd dátuma


// --- 2.91. DateTime osztály használata -----------------------
$date = new DateTime("2025-05-15 14:30:00");
echo $date->format("Y-m-d H:i:s");  // 2025-05-15 14:30:00

$date->modify("+1 month");
echo $date->format("Y-m-d H:i:s");  // 2025-06-15 14:30:00

$date->add(new DateInterval("P2D"));  // 2 nap hozzáadása
echo $date->format("Y-m-d H:i:s");    // 2025-06-17 14:30:00

$date->sub(new DateInterval("PT3H")); // 3 óra kivonása
echo $date->format("Y-m-d H:i:s");    // 2025-06-17 11:30:00


// --- 2.92. DateInterval és DatePeriod használata -------------
$interval = new DateInterval("P1Y2M3DT4H5M6S");  
// 1 év, 2 hónap, 3 nap, 4 óra, 5 perc, 6 másodperc

$date = new DateTime("2025-01-01");
$date->add($interval);

echo $date->format("Y-m-d H:i:s");  
// 2026-03-04 04:05:06

$start = new DateTime("2025-01-01");
$interval = new DateInterval("P1D");
$end = new DateTime("2025-01-10");

$period = new DatePeriod($start, $interval, $end);

foreach ($period as $date) {
    echo $date->format("Y-m-d") . "\n";
}


// --- 2.93. Időzónák kezelése ---------------------------------
$date = new DateTime("now", new DateTimeZone("Europe/Budapest"));
echo $date->format("Y-m-d H:i:s");

$date->setTimezone(new DateTimeZone("America/New_York"));
echo $date->format("Y-m-d H:i:s");


// --- 2.94. Dátumok összehasonlítása és különbségek számítása ---
$date1 = new DateTime("2025-05-15");
$date2 = new DateTime("2025-06-15");

if ($date1 < $date2) {
    echo "date1 korábbi, mint date2\n";
}

$diff = $date1->diff($date2);

echo $diff->format("%R%a nap\n");  // +31 nap

echo "Év különbség: " . $diff->y . "\n";
echo "Hónap különbség: " . $diff->m . "\n";
echo "Nap különbség: " . $diff->d . "\n";

echo "Összes nap különbség: " . $diff->days . "\n";


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Adott időpont időbélyege a mktime() függvénnyel
// Paraméterek sorrendje: óra, perc, másodperc, hónap, nap, év
$ts = mktime(0, 0, 0, 12, 31, 2025);
echo date("Y-m-d", $ts) . PHP_EOL;  // 2025-12-31

// Dátum létrehozása egyedi formátumú sztringből
$fromFormat = DateTime::createFromFormat("d/m/Y", "29/04/2025");
echo $fromFormat->format("Y-m-d") . PHP_EOL;  // 2025-04-29

// Relatív módosítások
$date = new DateTime("2025-12-31");
$date->modify("+7 days");
echo $date->format("Y-m-d") . PHP_EOL;        // 2026-01-07
$date->modify("next Monday");
echo $date->format("Y-m-d (l)") . PHP_EOL;    // 2026-01-12 (Monday)

// Heti ismétlődés DatePeriod segítségével
$period = new DatePeriod(
    new DateTime("2025-01-01"),
    new DateInterval("P1W"),
    new DateTime("2025-01-31")
);
foreach ($period as $day) {
    echo $day->format("Y-m-d") . PHP_EOL;
}
// 2025-01-01, 2025-01-08, 2025-01-15, 2025-01-22, 2025-01-29

// Időzóna-rövidítés a kiírásban (T formátumkarakter)
$dt = new DateTime("2025-07-01 12:00", new DateTimeZone("Europe/Bucharest"));
echo $dt->format("Y-m-d H:i T") . PHP_EOL;    // 2025-07-01 12:00 EEST
$dt->setTimezone(new DateTimeZone("America/New_York"));
echo $dt->format("Y-m-d H:i T") . PHP_EOL;    // 2025-07-01 05:00 EDT
