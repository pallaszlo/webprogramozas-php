<?php
$count = isset($_GET['count']) ? (int)$_GET['count'] + 1 : 1;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>URL paraméter alapú számláló</title>
</head>
<body>

<h1>URL paraméter alapú állapotkövetés</h1>
<p>Oldal megtekintve: <strong><?= $count ?></strong> alkalommal</p>
<a href="?count=<?= $count ?>">Következő oldal</a>

<h2>Aktuális URL</h2>
<code><?= htmlspecialchars($_SERVER['REQUEST_URI']) ?></code>

<h2>$_GET tartalma</h2>
<pre><?= htmlspecialchars(print_r($_GET, true)) ?></pre>

</body>
</html>
