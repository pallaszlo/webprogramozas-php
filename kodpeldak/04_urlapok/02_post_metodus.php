<?php
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

$nev    = htmlspecialchars($_POST['nev']    ?? '');
$email  = htmlspecialchars($_POST['email']  ?? '');
$uzenet = htmlspecialchars($_POST['uzenet'] ?? '');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>POST metódus példa</title>
</head>
<body>

<h1>Kapcsolati űrlap – POST metódus</h1>

<form method="POST">
    <p>
        <label>Név: <input type="text" name="nev" value="<?= $nev ?>"></label>
    </p>
    <p>
        <label>E-mail: <input type="email" name="email" value="<?= $email ?>"></label>
    </p>
    <p>
        <label>Üzenet:<br>
            <textarea name="uzenet" rows="4" cols="40"><?= $uzenet ?></textarea>
        </label>
    </p>
    <button type="submit">Küldés</button>
</form>

<?php if ($submitted): ?>
    <h2>Beküldött adatok</h2>
    <p><strong>Név:</strong> <?= $nev ?></p>
    <p><strong>E-mail:</strong> <?= $email ?></p>
    <p><strong>Üzenet:</strong> <?= $uzenet ?></p>
    <p><em>Az adatok nem jelennek meg az URL-ben.</em></p>
<?php endif; ?>

</body>
</html>
