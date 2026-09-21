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

// A süti beolvasása: csak a létező termékek azonosítói maradnak meg,
// így egy módosított süti sem okozhat hibát
$legutobb = json_decode($_COOKIE['legutobb'] ?? '[]', true);
$legutobb = is_array($legutobb) ? $legutobb : [];
$legutobb = array_filter($legutobb, fn($id) => is_int($id) && isset($termekek[$id]));

// Aktuálisan megtekintett termék
$termekId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (isset($termekek[$termekId])) {
    $legutobb = array_diff($legutobb, [$termekId]);  // ismétlődés eltávolítása
    array_unshift($legutobb, $termekId);            // az aktuális az elejére kerül
    $legutobb = array_slice($legutobb, 0, 5);       // legfeljebb 5 elem

    setcookie('legutobb', json_encode($legutobb), [
        'expires' => time() + 86400 * 7,
        'path'    => '/',
    ]);
}
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

<?php if (isset($termekek[$termekId])): ?>
    <p style="color:green;">
        Megtekintve: <strong><?= htmlspecialchars($termekek[$termekId]) ?></strong>
    </p>
<?php endif; ?>

<h2>Legutóbb megtekintett (max 5, 7 napig)</h2>
<?php if (!empty($legutobb)): ?>
    <ol>
        <?php foreach ($legutobb as $id): ?>
            <li><?= htmlspecialchars($termekek[$id]) ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <p>(Még nem tekintett meg terméket.)</p>
<?php endif; ?>

</body>
</html>
