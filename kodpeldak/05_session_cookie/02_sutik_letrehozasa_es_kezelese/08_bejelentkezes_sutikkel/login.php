<?php

// =============================================================
// 5.12. Bejelentkezés kezelése sütikkel (login.php)
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
// a tárolt jelszóhash (a jelszó: titok123)
$storedHash = password_hash('titok123', PASSWORD_DEFAULT);

// login.php - bejelentkezés és süti beállítása
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (password_verify($password, $storedHash)) {
        setcookie("felhasznalo", $username, [
            'expires'  => time() + 3600,
            'path'     => '/',
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        header("Location: fooldal.php");
        exit;
    }
}
?>

<!-- Kiegészítés (nem szerepel a könyvben): bejelentkező űrlap.
     A süti 'secure' beállítása miatt csak HTTPS-en, illetve helyi gépen
     (localhost) tárolja a böngésző. -->
<form method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="password" name="password" placeholder="Jelszó (titok123)">
    <input type="submit" value="Bejelentkezés">
</form>
