<?php

// ============================================================
// 5. feladat – Két időpont között eltelt idő
// ============================================================

function elteltIdo(string $idopontEgy, string $idopontKetto): array
{
    // Azonos alap dátumot használunk, hogy csak az idő számítson
    $d1 = new DateTime("2000-01-01 $idopontEgy");
    $d2 = new DateTime("2000-01-01 $idopontKetto");

    if ($d2 < $d1) {
        $d2->modify('+1 day');  // ha az idő átlépi az éjfélt
    }

    $diff = $d1->diff($d2);

    return [
        'ora'         => $diff->h + $diff->days * 24,
        'perc'        => $diff->i,
        'masodperc'   => $diff->s,
    ];
}

// Tesztek
$parok = [
    ['08:00:00', '14:30:00'],
    ['22:45:00', '06:15:30'],   // éjfélt átlép
    ['09:00:00', '09:00:00'],
];

foreach ($parok as [$tol, $ig]) {
    $ido = elteltIdo($tol, $ig);
    printf(
        "%s → %s : %d óra %d perc %d másodperc\n",
        $tol, $ig,
        $ido['ora'], $ido['perc'], $ido['masodperc']
    );
}
