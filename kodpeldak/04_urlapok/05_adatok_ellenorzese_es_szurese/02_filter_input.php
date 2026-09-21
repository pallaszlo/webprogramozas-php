<?php

// =============================================================
// 4.27. filter_input() használata
// =============================================================

// Email cím olvasása és validálása POST-ból
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($email === false) {
    echo "Érvénytelen email cím formátum.";
} elseif ($email === null) {
    echo "Az email mező nem lett elküldve.";
} else {
    echo "Érvényes email: " . htmlspecialchars($email);
}

// Egész szám olvasása és validálása GET-ből
$age = filter_input(INPUT_GET, 'age', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 18, 'max_range' => 99]
]);
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap a kipróbáláshoz.
     Az e-mail POST-tal, az életkor GET-tel (az URL-ben) érkezik. -->
<form method="POST" action="?age=25">
    <input type="text" name="email" placeholder="E-mail">
    <input type="submit" value="Küldés">
</form>
<p>Az életkor (GET): <?php var_dump($age); ?></p>
