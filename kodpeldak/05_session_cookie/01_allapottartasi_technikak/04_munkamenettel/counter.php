<?php

// =============================================================
// 5.4. Kattintásszámláló munkamenettel
// =============================================================

session_start();
$_SESSION['count'] = isset($_SESSION['count']) ? $_SESSION['count'] + 1 : 1;
?>
<h1>Oldal megtekintve: <?= $_SESSION['count'] ?> alkalommal</h1>
<a href="counter.php">Következő</a>
