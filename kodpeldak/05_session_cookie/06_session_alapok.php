<?php
session_start();

$uzenet = '';

// Adat hozzáadása
if (isset($_POST['hozzaad'])) {
    $kulcs = htmlspecialchars(trim($_POST['kulcs'] ?? ''));
    $ertek = htmlspecialchars(trim($_POST['ertek'] ?? ''));
    if ($kulcs) {
        $_SESSION[$kulcs] = $ertek;
        $uzenet = "Hozzáadva: {$kulcs}";
    }
}

// Adat törlése
if (isset($_POST['torol'])) {
    $kulcs = $_POST['torol_kulcs'] ?? '';
    if (isset($_SESSION[$kulcs])) {
        unset($_SESSION[$kulcs]);
        $uzenet = "Törölve: {$kulcs}";
    }
}

// Teljes munkamenet törlése
if (isset($_POST['mindent_torol'])) {
    session_unset();
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Munkamenet alapjai</title>
</head>
<body>

<h1>Munkamenet (session) alapjai</h1>

<p><strong>Session ID:</strong> <code><?= session_id() ?></code></p>

<?php if ($uzenet): ?>
    <p style="color:green;"><?= $uzenet ?></p>
<?php endif; ?>

<h2>$_SESSION tartalma</h2>
<?php if (!empty($_SESSION)): ?>
    <table border="1" cellpadding="5">
        <tr><th>Kulcs</th><th>Érték</th><th>Törlés</th></tr>
        <?php foreach ($_SESSION as $kulcs => $ertek): ?>
            <tr>
                <td><?= htmlspecialchars($kulcs) ?></td>
                <td><?= htmlspecialchars((string)$ertek) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="torol_kulcs" value="<?= htmlspecialchars($kulcs) ?>">
                        <button type="submit" name="torol" value="1">Törlés</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>(A munkamenet üres.)</p>
<?php endif; ?>

<h2>Adat hozzáadása</h2>
<form method="POST">
    <label>Kulcs: <input type="text" name="kulcs" placeholder="pl. felhasznalonev"></label>
    <label>Érték: <input type="text" name="ertek" placeholder="pl. kovacs_peter"></label>
    <button type="submit" name="hozzaad" value="1">Hozzáadás</button>
</form>

<form method="POST" style="margin-top:1em;">
    <button type="submit" name="mindent_torol" value="1"
        onclick="return confirm('Biztosan törölsz mindent?')">
        Munkamenet teljes törlése
    </button>
</form>

</body>
</html>
