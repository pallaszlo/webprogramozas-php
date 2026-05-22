<?php
$errors  = [];
$success = isset($_GET['success']) && $_GET['success'] === '1';

$nev   = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev   = trim($_POST['nev']   ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($nev)) {
        $errors[] = 'A név megadása kötelező.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Érvénytelen e-mail cím.';
    }
    if (strlen($_POST['jelszo'] ?? '') < 6) {
        $errors[] = 'A jelszónak legalább 6 karakter hosszúnak kell lennie.';
    }

    if (empty($errors)) {
        // Sikeres feldolgozás → PRG: átirányítás GET-re
        header('Location: index.php?success=1');
        exit;
    }
    // Hiba esetén maradunk az oldalon, nem irányítunk át

    $nev   = htmlspecialchars($nev);
    $email = htmlspecialchars($email);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció – PRG minta</title>
</head>
<body>

<h1>Regisztráció – Post–Redirect–Get minta</h1>

<?php if ($success): ?>
    <p style="color:green;">Sikeres regisztráció! (Az F5 nem küld újabb adatokat.)</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $hiba): ?>
            <li><?= htmlspecialchars($hiba) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <p><label>Név: <input type="text" name="nev" value="<?= $nev ?>" required></label></p>
    <p><label>E-mail: <input type="email" name="email" value="<?= $email ?>" required></label></p>
    <p><label>Jelszó: <input type="password" name="jelszo" required></label></p>
    <button type="submit">Regisztráció</button>
</form>

</body>
</html>
