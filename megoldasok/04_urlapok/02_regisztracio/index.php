<?php
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

$nemek       = ['ferfi' => 'Férfi', 'no' => 'Nő'];
$erdeklodesi = ['sport' => 'Sport', 'zene' => 'Zene', 'olvasas' => 'Olvasás', 'utazas' => 'Utazás', 'film' => 'Film'];
$lakhelyek   = ['Kolozsvár', 'Csíkszereda', 'Marosvásárhely', 'Nagyvárad', 'Temesvár'];

// A nyers értékeket tároljuk, a HTML-kódolás csak kiíráskor történik
$user       = (array) ($_POST['user'] ?? []);
$name       = trim($user['name']  ?? '');
$email      = trim($user['email'] ?? '');
$age        = trim($user['age']   ?? '');
$phone      = trim($user['phone'] ?? '');
$nem        = $_POST['nem']     ?? '';
$erdeklodes = (array) ($_POST['erdeklodes'] ?? []);  // egyetlen érték is tömb lesz
$lakhely    = $_POST['lakhely'] ?? '';

if ($submitted) {
    // A rádiógomb értékének ellenőrzése az engedélyezett értékek listája alapján
    if (!array_key_exists($nem, $nemek)) {
        $nem = '';
    }
    // Érdeklődési körök: csak az engedélyezett értékek maradnak
    $erdeklodes = array_values(array_intersect($erdeklodes, array_keys($erdeklodesi)));
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
</head>
<body>

<h1>Regisztráció</h1>

<?php if ($submitted): ?>
    <h2>Beküldött adatok</h2>
    <p><strong>Felhasználónév:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Életkor:</strong> <?= htmlspecialchars($age) ?></p>
    <p><strong>Telefon:</strong> <?= htmlspecialchars($phone) ?></p>
    <p><strong>Nem:</strong> <?= htmlspecialchars($nemek[$nem] ?? '(nincs megadva)') ?></p>
    <p><strong>Lakhely:</strong> <?= htmlspecialchars($lakhely) ?></p>
    <p><strong>Érdeklődési körök:</strong>
        <?php if (empty($erdeklodes)): ?>
            (nincs)
        <?php else: ?>
            <?= htmlspecialchars(implode(', ', array_map(fn($e) => $erdeklodesi[$e], $erdeklodes))) ?>
        <?php endif; ?>
    </p>
    <hr>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="user[name]" value="<?= htmlspecialchars($name) ?>"></label></p>
    <p><label>E-mail: <input type="email" name="user[email]" value="<?= htmlspecialchars($email) ?>"></label></p>
    <p><label>Életkor: <input type="number" name="user[age]" value="<?= htmlspecialchars($age) ?>"></label></p>
    <p><label>Telefon: <input type="text" name="user[phone]" value="<?= htmlspecialchars($phone) ?>"></label></p>
    <p><label>Jelszó: <input type="password" name="user[password]"></label></p>

    <p>Nem:
        <?php foreach ($nemek as $ertek => $cimke): ?>
            <label>
                <input type="radio" name="nem" value="<?= $ertek ?>"
                    <?= $nem === $ertek ? 'checked' : '' ?>> <?= $cimke ?>
            </label>
        <?php endforeach; ?>
    </p>

    <p>Érdeklődési körök:
        <?php foreach ($erdeklodesi as $ertek => $cimke): ?>
            <label>
                <input type="checkbox" name="erdeklodes[]" value="<?= $ertek ?>"
                    <?= in_array($ertek, $erdeklodes, true) ? 'checked' : '' ?>> <?= $cimke ?>
            </label>
        <?php endforeach; ?>
    </p>

    <p>
        <label>Lakhely:
            <select name="lakhely">
                <?php foreach ($lakhelyek as $varos): ?>
                    <option value="<?= htmlspecialchars($varos) ?>" <?= $lakhely === $varos ? 'selected' : '' ?>>
                        <?= htmlspecialchars($varos) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>

    <button type="submit">Regisztráció</button>
</form>

</body>
</html>
