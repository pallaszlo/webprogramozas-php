<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nev   = htmlspecialchars(trim($_POST['nev']   ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));

// Adatok feldolgozása (pl. adatbázisba mentés) itt történne

// PRG: sikeres feldolgozás után átirányítás GET-re
header('Location: index.php?success=1');
exit;
