<?php

// =============================================================
// 5.2. Kattintásszámláló rejtett mezővel
// =============================================================

$count = isset($_POST['count']) ? (int)$_POST['count'] + 1 : 1;
?>
<h1>Oldal megtekintve: <?= $count ?> alkalommal</h1>
<form method="POST" action="counter.php">
    <input type="hidden" name="count" value="<?= $count ?>">
    <input type="submit" value="Következő">
</form>
