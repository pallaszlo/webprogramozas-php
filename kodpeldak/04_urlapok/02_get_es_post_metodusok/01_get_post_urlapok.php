<?php

// =============================================================
// 4.2. GET és POST metódusok: a könyv 4.5–4.8. kódpéldái
// =============================================================


// --- 4.7. GET- és POST-adatok elérése PHP-ben ----------------

// GET adat elérése
$username = $_GET['username'] ?? '';

// POST adat elérése
$password = $_POST['password'] ?? '';

// Mindkét metódus adatainak elérése
$email = $_REQUEST['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>GET és POST metódusok</title>
</head>
<body>

<h2>4.5. kódpélda: GET metódus használata</h2>
<form method="GET">
    <input type="text" name="username" />
    <input type="submit" value="Keresés" />
</form>

<!-- Kiegészítés: a GET-tel küldött adat kiírása a 4.7. kódpélda változójából -->
<?php if ($username !== ''): ?>
    <p>A GET-tel kapott felhasználónév: <?= htmlspecialchars($username) ?></p>
<?php endif; ?>

<h2>4.6. kódpélda: POST metódus használata</h2>
<form action="process.php" method="POST">
    <input type="text" name="username" />
    <input type="password" name="password" />
    <input type="submit" value="Bejelentkezés" />
</form>

<h2>4.8. kódpélda: Űrlap külön feldolgozó fájllal</h2>
<form action="process.php" method="POST">
    <input type="text" name="username" />
    <input type="submit" value="Küldés" />
</form>

</body>
</html>
