<?php

// =============================================================
// 5.3. Kattintásszámláló sütikkel
// =============================================================

$count = isset($_COOKIE['count']) ? (int)$_COOKIE['count'] + 1 : 1;
setcookie('count', $count, time() + 3600); // 1 óra lejárat
?>
<h1>Oldal megtekintve: <?= $count ?> alkalommal</h1>
<a href="counter.php">Következő</a>
