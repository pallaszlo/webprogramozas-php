<?php
$search    = htmlspecialchars($_GET['search']    ?? '');
$minAr     = (int) ($_GET['min_ar']              ?? 0);
$maxAr     = (int) ($_GET['max_ar']              ?? 0);
$kategoria = htmlspecialchars($_GET['kategoria'] ?? '');

$submitted = array_key_exists('search', $_GET);

$kategoriak = [
    'elektronika' => 'Elektronika',
    'ruha'        => 'Ruha',
    'konyv'       => 'Könyv',
];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>GET metódus példa</title>
</head>
<body>

<h1>Termékkeresés – GET metódus</h1>

<form method="GET">
    <p>
        <label>Keresőszó:
            <input type="text" name="search" value="<?= $search ?>">
        </label>
    </p>
    <p>
        <label>Min ár (RON): <input type="number" name="min_ar" value="<?= $minAr ?>"></label>
        <label>Max ár (RON): <input type="number" name="max_ar" value="<?= $maxAr ?>"></label>
    </p>
    <p>
        <label>Kategória:
            <select name="kategoria">
                <option value="">– válassz –</option>
                <?php foreach ($kategoriak as $ertek => $cimke): ?>
                    <option value="<?= $ertek ?>" <?= $kategoria === $ertek ? 'selected' : '' ?>>
                        <?= $cimke ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>
    <button type="submit">Keresés</button>
</form>

<?php if ($submitted): ?>
    <h2>Beküldött adatok</h2>
    <p><strong>Keresőszó:</strong> <?= $search ?: '(üres)' ?></p>
    <p><strong>Ár:</strong> <?= $minAr ?> – <?= $maxAr ?> RON</p>
    <p><strong>Kategória:</strong> <?= $kategoriak[$_GET['kategoria']] ?? '(nincs megadva)' ?></p>

    <h2>Az aktuális URL</h2>
    <code><?= htmlspecialchars($_SERVER['REQUEST_URI']) ?></code>
<?php endif; ?>

</body>
</html>
