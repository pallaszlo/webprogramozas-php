<?php /* Kiegészítés (nem szerepel a könyvben): új hallgató űrlapja */ ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Új hallgató</title>
</head>
<body>
    <h1>Új hallgató</h1>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>Érvénytelen adatok (a név és egy érvényes e-mail-cím kötelező).</p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Név" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <button type="submit">Létrehozás</button>
    </form>
    <p><a href="index.php?action=index">Vissza a listához</a></p>
</body>
</html>
