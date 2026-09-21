<?php

// =============================================================
// 5.17. Hasznos munkamenet-függvények
// =============================================================


// session_name() csak session_start() ELŐTT hívható
session_name('AlkalmazasSession');
session_start();

echo "Session név: " . session_name() . "<br>";
echo "Session ID: " . session_id() . "<br>";

// Session fixation védelem:
// új azonosító generálása
session_regenerate_id(true);

// Session állapot ellenőrzése
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
