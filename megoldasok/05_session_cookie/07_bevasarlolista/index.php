<?php
session_start();

if (!isset($_SESSION['lista'])) {
    $_SESSION['lista'] = [];
}

// A munkamenetben a nyers szöveget tároljuk, HTML-kódolás csak kiíráskor történik.

// Tétel hozzáadása
if (isset($_POST['hozzaad'])) {
    $megnevezes = trim($_POST['megnevezes'] ?? '');
    $mennyiseg  = max(1, (int)($_POST['mennyiseg'] ?? 1));

    if ($megnevezes !== '') {
        $_SESSION['lista'][] = [
            'megnevezes' => $megnevezes,
            'mennyiseg'  => $mennyiseg,
        ];
        $_SESSION['flash'] = 'Tétel hozzáadva.';
    }

    // PRG: átirányítás, így az oldal frissítése nem küldi be újra az űrlapot
    header('Location: index.php');
    exit;
}

// Tétel törlése
if (isset($_POST['torol'])) {
    $idx = (int)($_POST['index'] ?? -1);
    if (isset($_SESSION['lista'][$idx])) {
        array_splice($_SESSION['lista'], $idx, 1);
        $_SESSION['flash'] = 'Tétel törölve.';
    }

    header('Location: index.php');
    exit;
}

// A flash üzenetet kiolvasás után töröljük, így csak egyszer jelenik meg
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bevásárlólista</title>
</head>
<body>

<h1>Bevásárlólista (munkamenet)</h1>
<p><em>A lista a böngésző bezárásáig megmarad.</em></p>

<?php if ($flash): ?>
    <p style="color:green;"><?= htmlspecialchars($flash) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Tétel: <input type="text" name="megnevezes" placeholder="pl. Tej" required></label>
    <label>Mennyiség: <input type="number" name="mennyiseg" value="1" min="1" style="width:60px;"></label>
    <button type="submit" name="hozzaad" value="1">Hozzáadás</button>
</form>

<h2>Lista</h2>
<?php if (empty($_SESSION['lista'])): ?>
    <p style="color:gray;"><em>A lista üres. Adjon hozzá tételeket!</em></p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <tr><th>#</th><th>Megnevezés</th><th>Mennyiség</th><th></th></tr>
        <?php foreach ($_SESSION['lista'] as $idx => $tetel): ?>
            <tr>
                <td><?= $idx + 1 ?></td>
                <td><?= htmlspecialchars($tetel['megnevezes']) ?></td>
                <td><?= (int)$tetel['mennyiseg'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="index" value="<?= $idx ?>">
                        <button type="submit" name="torol" value="1">Törlés</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Összesen: <?= count($_SESSION['lista']) ?> tétel</strong></p>
<?php endif; ?>

</body>
</html>
