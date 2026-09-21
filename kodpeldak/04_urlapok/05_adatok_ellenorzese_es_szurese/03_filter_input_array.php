<?php

// =============================================================
// 4.28. filter_input_array() használata
// =============================================================

// Kiegészítés: a szűrés csak POST kérésnél fut (nem szerepel a könyvben)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$filters = [
    'username' => FILTER_DEFAULT,
    'email' => FILTER_VALIDATE_EMAIL,
    'age' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' => 18, 'max_range' => 99]
    ],
    'website' => FILTER_VALIDATE_URL
];

$inputs = filter_input_array(INPUT_POST, $filters);

if ($inputs['email'] === false) {
    echo "Érvénytelen email!";
}
    // Kiegészítés: az eredmény kiírása
    echo '<pre>' . htmlspecialchars(print_r($inputs, true)) . '</pre>';
} // a kiegészítés vége
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap a kipróbáláshoz -->
<form method="POST">
    <input type="text" name="username" placeholder="Felhasználónév">
    <input type="text" name="email" placeholder="E-mail">
    <input type="text" name="age" placeholder="Életkor">
    <input type="text" name="website" placeholder="Weboldal">
    <input type="submit" value="Küldés">
</form>
