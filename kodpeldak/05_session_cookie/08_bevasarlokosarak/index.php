<?php
session_start();

// Munkamenet alapú kosár inicializálása
if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}

// Süti alapú kosár betöltése
$sutiKosar = isset($_COOKIE['kosar'])
    ? (json_decode($_COOKIE['kosar'], true) ?? [])
    : [];

$termekek = [
    1 => ['nev' => 'Laptop',      'ar' => 4500],
    2 => ['nev' => 'Egér',        'ar' => 120],
    3 => ['nev' => 'Billentyűzet','ar' => 250],
];

// Hozzáadás (munkamenet kosárhoz)
if (isset($_POST['hozzaad'])) {
    $id = (int)$_POST['termek_id'];
    if (isset($termekek[$id])) {
        $_SESSION['kosar'][$id] = ($_SESSION['kosar'][$id] ?? 0) + 1;
    }
}

// Eltávolítás
if (isset($_POST['torol'])) {
    $id = (int)$_POST['termek_id'];
    unset($_SESSION['kosar'][$id]);
}

// Munkamenet kosár mentése sütibe is
setcookie('kosar', json_encode($_SESSION['kosar']), [
    'expires' => time() + 86400,
    'path'    => '/',
]);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bevásárlókosár</title>
</head>
<body>

<h1>Bevásárlókosár – süti és munkamenet összehasonlítás</h1>

<h2>Termékek</h2>
<?php foreach ($termekek as $id => $t): ?>
    <form method="POST" style="display:inline;">
        <input type="hidden" name="termek_id" value="<?= $id ?>">
        <?= htmlspecialchars($t['nev']) ?> (<?= $t['ar'] ?> RON)
        <button type="submit" name="hozzaad" value="1">Kosárba</button>
    </form><br>
<?php endforeach; ?>

<h2>Munkamenet kosár ($_SESSION)</h2>
<?php if (!empty($_SESSION['kosar'])): ?>
    <?php $osszeg = 0; ?>
    <?php foreach ($_SESSION['kosar'] as $id => $db): ?>
        <?php $ar = $termekek[$id]['ar'] ?? 0; $osszeg += $ar * $db; ?>
        <p>
            <?= htmlspecialchars($termekek[$id]['nev'] ?? "#{$id}") ?>:
            <?= $db ?> db (<?= $ar * $db ?> RON)
            <form method="POST" style="display:inline;">
                <input type="hidden" name="termek_id" value="<?= $id ?>">
                <button type="submit" name="torol" value="1">Törlés</button>
            </form>
        </p>
    <?php endforeach; ?>
    <p><strong>Összesen: <?= $osszeg ?> RON</strong></p>
<?php else: ?>
    <p>(Üres)</p>
<?php endif; ?>

<h2>Süti kosár ($_COOKIE) – előző látogatás állapota</h2>
<pre><?= htmlspecialchars(print_r($sutiKosar, true)) ?></pre>

</body>
</html>
