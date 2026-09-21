<?php

// =============================================================
// 4.20. Összetett űrlap feldolgozása
// =============================================================
?>
<form method="POST">
    <input type="text" name="user[name]" />
    <input type="email" name="user[email]" />
    <input type="checkbox" name="interests[]" value="sport" />
    <input type="checkbox" name="interests[]" value="music" />
    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user      = $_POST['user'] ?? [];
    $interests = $_POST['interests'] ?? [];

    echo "Név: " . htmlspecialchars($user['name'] ?? '') . "<br>";
    echo "Email: " . htmlspecialchars($user['email'] ?? '') . "<br>";

    $safeInterests = array_map('htmlspecialchars', $interests);
    echo "Érdeklődési körök: " . implode(", ", $safeInterests);
}
?>
