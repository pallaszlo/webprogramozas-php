<?php /* Kiegészítés (nem szerepel a könyvben): a hallgató adatai */ ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Hallgató adatai</title>
</head>
<body>
    <h1><?= htmlspecialchars($student['name']) ?></h1>
    <p>E-mail: <?= htmlspecialchars($student['email']) ?></p>
    <p><a href="index.php?action=index">Vissza a listához</a></p>
</body>
</html>
