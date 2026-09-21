<?php

// =============================================================
// 4.35. Biztonságos jelszókezelés
// =============================================================

// Kiegészítés: a kód csak POST kérésnél fut (nem szerepel a könyvben)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


// Regisztráció
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Bejelentkezés
$inputPassword = $_POST['password'];
$storedHash = '...';

if (password_verify($inputPassword, $storedHash)) {
    echo "Sikeres bejelentkezés!";

    if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
        $newHash = password_hash($inputPassword, PASSWORD_DEFAULT);
        // adatbázis frissítése
    }
}
} // a kiegészítés vége
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap a kipróbáláshoz -->
<form method="POST">
    <input type="password" name="password" placeholder="Jelszó">
    <input type="submit" value="Küldés">
</form>
