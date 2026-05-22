<?php
session_start([
    'use_strict_mode'  => true,
    'use_only_cookies' => true,
    'cookie_httponly'  => true,
    'cookie_samesite'  => 'Strict',
]);

$timeout  = 300; // 5 perc inaktivitás
$kilepett = false;

// Timeout ellenőrzése
if (isset($_SESSION['last_activity']) &&
    time() - $_SESSION['last_activity'] > $timeout) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['timeout_uzenet'] = true;
}

$_SESSION['last_activity'] = time();

// Bejelentkezés szimuláció
if (isset($_POST['belepes'])) {
    // Bejelentkezés előtt: új session ID (session fixation ellen)
    session_regenerate_id(true);
    $_SESSION['felhasznalo'] = 'demo_felhasznalo';
    $_SESSION['belepve']     = true;
}

// Kijelentkezés
if (isset($_POST['kilepes'])) {
    session_unset();
    session_destroy();
    $kilepett = true;
    session_start();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Munkamenet biztonság</title>
</head>
<body>

<h1>Munkamenet biztonsági technikák</h1>

<?php if (isset($_SESSION['timeout_uzenet'])): ?>
    <p style="color:orange;">A munkamenet lejárt inaktivitás miatt.</p>
    <?php unset($_SESSION['timeout_uzenet']); ?>
<?php endif; ?>

<?php if ($kilepett): ?>
    <p style="color:gray;">Kijelentkezve.</p>
<?php endif; ?>

<h2>Session állapot</h2>
<p><strong>Session ID:</strong> <code><?= session_id() ?></code></p>
<p><strong>Bejelentkezve:</strong> <?= isset($_SESSION['belepve']) ? 'igen' : 'nem' ?></p>
<?php if (isset($_SESSION['last_activity'])): ?>
    <p><strong>Utolsó aktivitás:</strong>
        <?= date('H:i:s', $_SESSION['last_activity']) ?>
        (timeout: <?= $timeout ?> mp)
    </p>
<?php endif; ?>

<?php if (!isset($_SESSION['belepve'])): ?>
    <form method="POST">
        <button type="submit" name="belepes" value="1">Bejelentkezés (session_regenerate_id demo)</button>
    </form>
<?php else: ?>
    <p>Üdvözöljük, <strong><?= htmlspecialchars($_SESSION['felhasznalo']) ?></strong>!</p>
    <form method="POST">
        <button type="submit" name="kilepes" value="1">Kijelentkezés</button>
    </form>
<?php endif; ?>

<h2>$_SESSION</h2>
<pre><?= htmlspecialchars(print_r($_SESSION, true)) ?></pre>

</body>
</html>
