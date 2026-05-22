<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>PHP beágyazás HTML-be</title>
</head>
<body>
    <h1>Üdvözlő oldal</h1>

    <?php
    $name = "Kovács Anna";
    $age  = 25;
    ?>

    <!-- Standard echo -->
    <?php echo "<p>Helló, $name!</p>"; ?>

    <!-- Rövid echo tag – ajánlott HTML-ben -->
    <p>Kor: <?= $age ?> év</p>
</body>
</html>
