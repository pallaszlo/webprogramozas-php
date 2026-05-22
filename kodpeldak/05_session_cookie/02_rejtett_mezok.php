<?php
$count = isset($_POST['count']) ? (int)$_POST['count'] + 1 : 1;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Rejtett mező alapú számláló</title>
</head>
<body>

<h1>Rejtett mező alapú állapotkövetés</h1>
<p>Oldal megtekintve: <strong><?= $count ?></strong> alkalommal</p>

<form method="POST">
    <input type="hidden" name="count" value="<?= $count ?>">
    <button type="submit">Következő</button>
</form>

<p><em>Az URL nem változik — az adat a POST kérés törzsében utazik.</em></p>

</body>
</html>
