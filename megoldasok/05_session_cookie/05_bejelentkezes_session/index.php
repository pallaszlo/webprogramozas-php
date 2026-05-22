<?php
session_start([
    'use_strict_mode'  => true,
    'use_only_cookies' => true,
    'cookie_httponly'  => true,
    'cookie_samesite'  => 'Strict',
]);

$felhasznalok = [
    'admin'  => password_hash('admin123',  PASSWORD_DEFAULT),
    'tanulo' => password_hash('jelszo456', PASSWORD_DEFAULT),
];

$uzenet  = '';
$sikeres = false;

// Kijelentkezés
if (isset($_POST['kilepes'])) {
    session_unset();
    session_destroy();

    // Session süti törlése a böngészőből
    setcookie(session_name(), '', ['expires' => time() - 3600, 'path' => '/']);

    header('Location: index.php');
    exit;
}

// Bejelentkezés
if (isset($_POST['belepes'])) {
    $nev    = trim($_POST['nev']    ?? '');
    $jelszo = trim($_POST['jelszo'] ?? '');

    if (isset($felhasznalok[$nev]) && password_verify($jelszo, $felhasznalok[$nev])) {
        // Session fixation elleni védelem: új azonosító generálása
        session_regenerate_id(true);

        $_SESSION['felhasznalo']    = $nev;
        $_SESSION['belepve']        = true;
        $_SESSION['belepett_mikor'] = time();

        header('Location: index.php');
        exit;
    } else {
        $uzenet = 'Hibás felhasználónév vagy jelszó.';
    }
}

$bejelentkezve = isset($_SESSION['belepve']) && $_SESSION['belepve'] === true;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés munkamenettel</title>
</head>
<body>

<h1>Bejelentkezés – munkamenet</h1>
<p><em>Teszt fiókok: <code>admin / admin123</code>, <code>tanulo / jelszo456</code></em></p>

<?php if ($uzenet): ?>
    <p style="color:red;"><?= htmlspecialchars($uzenet) ?></p>
<?php endif; ?>

<?php if ($bejelentkezve): ?>
    <p style="color:green;">Üdvözöljük, <strong><?= htmlspecialchars($_SESSION['felhasznalo']) ?></strong>!</p>
    <p>Bejelentkezés ideje: <?= date('H:i:s', $_SESSION['belepett_mikor']) ?></p>
    <p>Session ID: <code><?= session_id() ?></code></p>

    <form method="POST">
        <button type="submit" name="kilepes" value="1">Kijelentkezés</button>
    </form>
<?php else: ?>
    <form method="POST">
        <p><label>Felhasználónév: <input type="text" name="nev"></label></p>
        <p><label>Jelszó: <input type="password" name="jelszo"></label></p>
        <button type="submit" name="belepes" value="1">Bejelentkezés</button>
    </form>
<?php endif; ?>

</body>
</html>
