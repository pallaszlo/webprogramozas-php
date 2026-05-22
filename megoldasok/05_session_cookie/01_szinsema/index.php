<?php
// Séma váltása gombra kattintáskor
if (isset($_POST['valtas'])) {
    $jelenlegi = $_COOKIE['szinsema'] ?? 'vilagos';
    $uj        = $jelenlegi === 'vilagos' ? 'sotet' : 'vilagos';
    setcookie('szinsema', $uj, ['expires' => time() + 86400 * 30, 'path' => '/']);
    header('Location: index.php');
    exit;
}

$sema = $_COOKIE['szinsema'] ?? 'vilagos';

$stilus = $sema === 'sotet'
    ? 'background:#1a1a1a; color:#f0f0f0;'
    : 'background:#ffffff; color:#1a1a1a;';

$gombSzoveg = $sema === 'sotet' ? '☀️ Világos mód' : '🌙 Sötét mód';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Színséma választó</title>
    <style>body { <?= $stilus ?> padding: 2em; font-family: sans-serif; }</style>
</head>
<body>

<h1>Színséma süti</h1>
<p>Aktuális séma: <strong><?= htmlspecialchars($sema) ?></strong></p>
<p>A süti 30 napig megőrzi a beállítást.</p>

<form method="POST">
    <button type="submit" name="valtas" value="1"><?= $gombSzoveg ?></button>
</form>

</body>
</html>
