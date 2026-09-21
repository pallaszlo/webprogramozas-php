<?php

// =============================================================
// 6.4. Biztonságos lekérdezés előkészített utasítással
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// ha az űrlapot még nem küldték el, egy mintaértékkel fut
$_POST['username'] ??= 'kiss_janos';

$username = $_POST['username'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

// Kiegészítés (nem szerepel a könyvben): a találatok és egy űrlap a kipróbáláshoz
$users = $stmt->fetchAll();
echo "<p>Találatok: " . count($users) . "</p>";
foreach ($users as $user) {
    echo htmlspecialchars($user['username']) . "<br>";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="submit" value="Keresés">
</form>
<p>Próbáljuk ki ezt a bemenetet: <code>' OR '1'='1</code></p>
