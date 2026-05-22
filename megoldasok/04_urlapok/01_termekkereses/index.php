<?php
$search    = $_GET['search']    ?? '';
$minAr     = (int) ($_GET['min_ar'] ?? 0);
$maxAr     = (int) ($_GET['max_ar'] ?? 0);
$kategoria = $_GET['kategoria'] ?? '';

$submitted  = array_key_exists('search', $_GET);
$kategoriak = ['elektronika' => 'Elektronika', 'ruha' => 'Ruha', 'konyv' => 'Könyv'];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Termékkeresés</title>
</head>
<body>

<h1>Termékkeresés</h1>

<form method="GET">
    <p>
        <label>Terméknév:
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>">
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
    <h2>Keresési feltételek</h2>
    <p><strong>Kategória:</strong> <?= htmlspecialchars($kategoriak[$kategoria] ?? 'Nincs megadva') ?></p>
    <p><strong>Ár:</strong> <?= $minAr ?> – <?= $maxAr ?> RON</p>

    <h2>XSS demonstráció</h2>
    <p><strong>Escape-elés nélkül (HELYTELEN – próbáld ki script taggel!):</strong></p>
    <p><?= $search ?></p>

    <p><strong>htmlspecialchars() védelemmel (HELYES):</strong></p>
    <p><?= htmlspecialchars($search) ?></p>

    <p><em>Teszt: írd be a keresőbe: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></em></p>
<?php endif; ?>

</body>
</html>
