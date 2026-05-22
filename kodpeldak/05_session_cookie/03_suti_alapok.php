<?php
$uzenet = '';

// Süti beállítása
if (isset($_POST['beallitas'])) {
    $nev   = htmlspecialchars(trim($_POST['nev']   ?? ''));
    $ertek = htmlspecialchars(trim($_POST['ertek'] ?? ''));
    if ($nev && $ertek) {
        setcookie($nev, $ertek, ['expires' => time() + 3600, 'path' => '/']);
        $uzenet = "Süti beállítva: {$nev} = {$ertek} (1 óra)";
    }
}

// Süti törlése
if (isset($_POST['torles'])) {
    $nev = htmlspecialchars(trim($_POST['torles_nev'] ?? ''));
    if ($nev) {
        setcookie($nev, '', ['expires' => time() - 3600, 'path' => '/']);
        $uzenet = "Süti törölve: {$nev}";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Sütik alapjai</title>
</head>
<body>

<h1>Sütik létrehozása, olvasása, törlése</h1>

<?php if ($uzenet): ?>
    <p style="color:green;"><?= $uzenet ?> — frissítsd az oldalt az eredmény megtekintéséhez.</p>
<?php endif; ?>

<h2>Aktuális sütik ($_COOKIE)</h2>
<?php if (!empty($_COOKIE)): ?>
    <table border="1" cellpadding="5">
        <tr><th>Név</th><th>Érték</th></tr>
        <?php foreach ($_COOKIE as $nev => $ertek): ?>
            <tr>
                <td><?= htmlspecialchars($nev) ?></td>
                <td><?= htmlspecialchars($ertek) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>(Még nincsenek sütik.)</p>
<?php endif; ?>

<h2>Süti beállítása</h2>
<form method="POST">
    <label>Név: <input type="text" name="nev" placeholder="pl. felhasznalo"></label>
    <label>Érték: <input type="text" name="ertek" placeholder="pl. kovacs_peter"></label>
    <button type="submit" name="beallitas" value="1">Beállítás</button>
</form>

<h2>Süti törlése</h2>
<form method="POST">
    <label>Törlendő süti neve: <input type="text" name="torles_nev"></label>
    <button type="submit" name="torles" value="1">Törlés</button>
</form>

</body>
</html>
