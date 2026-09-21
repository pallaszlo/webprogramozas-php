<?php

// =============================================================
// 4.34. CSRF-védelem implementálása
// =============================================================

session_start();

// CSRF token generálása
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// A beküldött token ellenőrzése az űrlap kiírása előtt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        die('Érvénytelen CSRF token!');
    }

    // Sikeres ellenőrzés után új token generálása
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<form method="POST" action="">
    <input type="hidden" name="csrf_token"
           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <input type="text" name="username">
    <input type="submit" value="Küldés">
</form>
