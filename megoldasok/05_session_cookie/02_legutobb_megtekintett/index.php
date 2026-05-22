<?php
$termekek = [
    1 => 'Laptop',
    2 => 'Okostelefon',
    3 => 'Tablet',
    4 => 'Fejhallgató',
    5 => 'Billentyűzet',
    6 => 'Egér',
    7 => 'Monitor',
];

// Aktuálisan megtekintett termék
$termekId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($termekId && isset($termekek[$termekId])) {
    // Beolvasás
    $lista = isset($_COOKIE['legutobb'])
        ? (json_decode($_COOKIE['legutobb'], true) ?? [])
        : [];

    // Ismétlődés eltávolítása
    $lista = array_filter($lista, fn($id) => $id !== $termekId);
    // Elejére rakjuk
    array_unshift($lista, $termekId);
    // Max 5 elem
    $lista = array_slice(array_values($lista), 0, 5);

    setcookie('legutobb', json_encode($lista), [
        'expires' => time() + 86400 * 7,
        'path'    => '/',
    ]);

    // Frissítés után újratöltés (hogy a süti beolvasható legyen)
    header('Location: index.php?id=' . $termekId . '&megnezve=1');
    exit;
}

$legutobb = isset($_COOKIE['legutobb'])
    ? (json_decode($_COOKIE['legutobb'], true) ?? [])
    : [];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Legutóbb megtekintett termékek</title>
</head>
<body>

<h1>Termékek</h1>
<ul>
    <?php foreach ($termekek as $id => $nev): ?>
        <li><a href="?id=<?= $id ?>"><?= htmlspecialchars($nev) ?></a></li>
    <?php endforeach; ?>
</ul>

<?php if (isset($_GET['megnezve']) && isset($termekek[(int)$_GET['id']])): ?>
    <p style="color:green;">
        Megtekintve: <strong><?= htmlspecialchars($termekek[(int)$_GET['id']]) ?></strong>
    </p>
<?php endif; ?>

<h2>Legutóbb megtekintett (max 5, 7 napig)</h2>
<?php if (!empty($legutobb)): ?>
    <ol>
        <?php foreach ($legutobb as $id): ?>
            <li><?= htmlspecialchars($termekek[$id] ?? "Ismeretlen #{$id}") ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <p>(Még nem tekintettél meg terméket.)</p>
<?php endif; ?>

</body>
</html>
