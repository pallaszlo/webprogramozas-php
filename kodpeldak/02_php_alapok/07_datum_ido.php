<?php

// ============================================================
// Dátum- és időkezelés: date/time, DateTime, DateInterval,
//                       DatePeriod, időzónák
// Kapcsolódó fejezet: 2.7. Dátum- és időkezelés
// ============================================================


// --- Aktuális időbélyeg és formázás ----------------------------

$timestamp = time();  // Unix időbélyeg (másodpercek 1970-01-01 óta)
echo $timestamp . PHP_EOL;

// date() – időbélyegből formázott string
echo date("Y-m-d")           . PHP_EOL;  // pl. 2025-04-29
echo date("Y. m. d. H:i:s")  . PHP_EOL;  // pl. 2025. 04. 29. 14:30:00
echo date("l, F j, Y")       . PHP_EOL;  // pl. Tuesday, April 29, 2025
echo date("D, d M Y")        . PHP_EOL;  // pl. Tue, 29 Apr 2025

// Leggyakoribb formátumjelek:
// Y – 4 jegyű év     m – 2 jegyű hónap   d – 2 jegyű nap
// H – 24h óra        i – percek           s – másodpercek
// l – nap neve       N – hét napja (1=H, 7=V)


// --- strtotime() – stringből időbélyeg -------------------------

$date = strtotime("2025-05-15 14:30:00");
echo date("Y-m-d H:i:s", $date) . PHP_EOL;  // 2025-05-15 14:30:00

$nextWeek = strtotime("+1 week", $date);
echo date("Y-m-d", $nextWeek) . PHP_EOL;    // 2025-05-22

$lastDay = strtotime("last day of May 2025");
echo date("Y-m-d", $lastDay) . PHP_EOL;     // 2025-05-31

$nextTuesday = strtotime("next Tuesday");
echo date("Y-m-d", $nextTuesday) . PHP_EOL; // következő kedd


// --- mktime() – adott időpont időbélyege -----------------------

$ts = mktime(0, 0, 0, 12, 31, 2025);  // 2025-12-31 00:00:00
echo date("Y-m-d", $ts) . PHP_EOL;

// Múltbeli dátum
$birthday = mktime(0, 0, 0, 6, 15, 1995);
echo date("Y-m-d", $birthday) . PHP_EOL;


// --- DateTime osztály ------------------------------------------

$now = new DateTime();
echo $now->format("Y-m-d H:i:s") . PHP_EOL;

// Adott dátum
$date = new DateTime("2025-12-31");
echo $date->format("Y. m. d.") . PHP_EOL;

// Módosítás
$date->modify("+7 days");
echo $date->format("Y-m-d") . PHP_EOL;  // 2026-01-07

$date->modify("next Monday");
echo $date->format("Y-m-d (l)") . PHP_EOL;

// Létrehozás formátumból
$fromFormat = DateTime::createFromFormat("d/m/Y", "29/04/2025");
echo $fromFormat->format("Y-m-d") . PHP_EOL;  // 2025-04-29


// --- DateInterval – időközök -----------------------------------

$start = new DateTime("2025-01-01");
$end   = new DateTime("2025-12-31");

$interval = $start->diff($end);
echo $interval->days    . " nap" . PHP_EOL;   // 364 nap
echo $interval->m       . " hónap" . PHP_EOL;
echo $interval->format("%y év %m hónap %d nap") . PHP_EOL;

// Dátum eltolása intervallummal
$start2 = new DateTime("2025-04-29");
$start2->add(new DateInterval("P1Y2M10D"));  // +1 év 2 hónap 10 nap
echo $start2->format("Y-m-d") . PHP_EOL;

$start2->sub(new DateInterval("P1M"));  // -1 hónap
echo $start2->format("Y-m-d") . PHP_EOL;


// --- DatePeriod – időszakon belüli ismétlődés ------------------

$begin    = new DateTime("2025-01-01");
$end2     = new DateTime("2025-01-31");
$interval = new DateInterval("P1W");  // heti ismétlés

$period = new DatePeriod($begin, $interval, $end2);
foreach ($period as $date) {
    echo $date->format("Y-m-d") . PHP_EOL;
}


// --- Időzónák --------------------------------------------------

date_default_timezone_set("Europe/Bucharest");
echo date("H:i:s") . PHP_EOL;

$dt = new DateTime("now", new DateTimeZone("Europe/Budapest"));
echo $dt->format("Y-m-d H:i:s T") . PHP_EOL;

// Időzóna átváltás
$dt->setTimezone(new DateTimeZone("America/New_York"));
echo $dt->format("Y-m-d H:i:s T") . PHP_EOL;


// --- Dátumok összehasonlítása ----------------------------------

$d1 = new DateTime("2025-06-01");
$d2 = new DateTime("2025-12-31");

if ($d1 < $d2) {
    echo "d1 korábbi" . PHP_EOL;
}

$diff = $d1->diff($d2);
echo "Köztük: " . $diff->days . " nap" . PHP_EOL;
