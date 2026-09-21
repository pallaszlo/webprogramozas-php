<?php

// =============================================================
// 5.21. Flash üzenet beállítása (save.php)
// =============================================================

session_start();
// ... feldolgozás ...
$_SESSION['flash'] = 'A hallgató sikeresen mentve.';
header('Location: index.php');
exit;
