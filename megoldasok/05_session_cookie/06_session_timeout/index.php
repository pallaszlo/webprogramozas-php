<?php
session_start();

$timeout       = 600; // 10 perc
$timeoutUzenet = false;

// Timeout ellenőrzése
if (isset($_SESSION['last_activity'])) {
    $eltelt = time() - $_SESSION['last_activity'];
    if ($eltelt > $timeout) {
        session_unset();
        session_destroy();
        header('Location: index.php?timeout=1');
        exit;
    }
}

// Aktivitás frissítése
$_SESSION['last_activity'] = time();

// Bejelentkezés
if (isset($_POST['belepes'])) {
    $_SESSION['felhasznalo'] = htmlspecialchars(trim($_POST['nev'] ?? 'vendeg'));
    $_SESSION['belepve']     = true;
    header('Location: index.php');
    exit;
}

// Kijelentkezés
if (isset($_POST['kilepes'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

$bejelentkezve = isset($_SESSION['belepve']);
$maradek       = $bejelentkezve
    ? max(0, $timeout - (time() - $_SESSION['last_activity']))
    : 0;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Session timeout</title>
    <?php if ($bejelentkezve): ?>
    <meta http-equiv="refresh" content="30"> <!-- 30mp-enként frissít -->
    <?php endif; ?>
</head>
<body>

<h1>Session timeout – 10 perces inaktivitás</h1>

<?php if (isset($_GET['timeout'])): ?>
    <p style="color:orange;">A munkamenet lejárt inaktivitás miatt. Jelentkezz be újra.</p>
<?php endif; ?>

<?php if ($bejelentkezve): ?>
    <p style="color:green;">
        Üdvözöljük, <strong><?= htmlspecialchars($_SESSION['felhasznalo']) ?></strong>!
    </p>
    <p>Utolsó aktivitás: <?= date('H:i:s', $_SESSION['last_activity']) ?></p>
    <p>Hátralévő idő: <strong><?= floor($maradek / 60) ?>p <?= $maradek % 60 ?>mp</strong></p>
    <p><em>Az oldal 30 másodpercenként frissül az aktivitás fenntartásához.</em></p>

    <form method="POST">
        <button type="submit" name="kilepes" value="1">Kijelentkezés</button>
    </form>
<?php else: ?>
    <form method="POST">
        <p><label>Felhasználónév: <input type="text" name="nev" value="demo_felhasznalo"></label></p>
        <button type="submit" name="belepes" value="1">Bejelentkezés</button>
    </form>
<?php endif; ?>

</body>
</html>
