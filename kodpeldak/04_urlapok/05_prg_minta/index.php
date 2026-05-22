<?php
$success = isset($_GET['success']) && $_GET['success'] === '1';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>PRG minta</title>
</head>
<body>

<h1>Feliratkozás – PRG minta</h1>

<?php if ($success): ?>
    <p style="color:green;">Sikeres feliratkozás! (Az oldal frissítése nem küld újabb adatokat.)</p>
<?php endif; ?>

<form method="POST" action="process.php">
    <p><label>Név: <input type="text" name="nev" required></label></p>
    <p><label>E-mail: <input type="email" name="email" required></label></p>
    <button type="submit">Feliratkozás</button>
</form>

</body>
</html>
