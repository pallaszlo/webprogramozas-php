<?php
// =============================================================
// 2.2. PHP-kód beágyazása HTML-be
// =============================================================
?>
<!DOCTYPE html>
<html>
<head>
    <title>Üdvözlő oldal</title>
</head>
<body>
    <h1>Üdvözöljük!</h1>
    <?php
    $name = "Kovács Anna";
    $age = 25;
    ?>

    <!-- Standard echo -->
    <?php echo "<p>Helló, $name!</p>"; ?>

    <!-- Rövid echo tag (ajánlott HTML-ben) -->
    <p>Kor: <?= $age ?> év</p>
</body>
</html>
