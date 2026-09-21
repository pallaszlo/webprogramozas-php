<?php

// =============================================================
// 5.1. Kattintásszámláló URL-paraméterrel
// =============================================================

$count = isset($_GET['count']) ? (int)$_GET['count'] + 1 : 1;
?>
<h1>Oldal megtekintve: <?= $count ?> alkalommal</h1>
<a href="counter.php?count=<?= $count ?>">Következő</a>
