<?php

// ============================================================
// 4. feladat – Hány péntek 13-a van egy adott évben?
// ============================================================

function pentekTizenharmak(int $ev): array
{
    $datumok = [];

    for ($honap = 1; $honap <= 12; $honap++) {
        $datum = new DateTime(sprintf("%04d-%02d-13", $ev, $honap));
        if ($datum->format('N') == 5) {  // N: 1=hétfő, 5=péntek
            $datumok[] = $datum->format('Y-m-d');
        }
    }

    return $datumok;
}

// Tesztek
foreach ([2025, 2026, 2027] as $ev) {
    $datumok = pentekTizenharmak($ev);
    $db      = count($datumok);
    printf("%d: %d péntek 13-a", $ev, $db);
    if ($db > 0) {
        echo " (" . implode(", ", $datumok) . ")";
    }
    echo PHP_EOL;
}
