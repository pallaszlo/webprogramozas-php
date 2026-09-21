<?php

// =============================================================
// 4.25. Szerveroldali validáció
// =============================================================

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Email validáció
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = "Az email cím megadása kötelező.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Érvénytelen email cím formátum.";
    }

    // Életkor validáció
    $age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);
    if ($age === false || $age < 18 || $age > 99) {
        $errors['age'] = "Az életkornak 18 és 99 között kell lennie.";
    }

    if (empty($errors)) {
        // Sikeres feldolgozás...
    }
}
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap és hibaüzenetek a kipróbáláshoz -->
<?php foreach ($errors as $error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
    <p style="color: green;">Az adatok megfelelnek.</p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="email" placeholder="E-mail">
    <input type="text" name="age" placeholder="Életkor">
    <input type="submit" value="Küldés">
</form>
