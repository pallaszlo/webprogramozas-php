<?php
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

$user       = $_POST['user']       ?? [];
$nem        = $_POST['nem']        ?? '';
$erdeklodes = $_POST['erdeklodes'] ?? [];
$lakhely    = $_POST['lakhely']    ?? '';

$nemWhitelist       = ['ferfi' => 'Férfi', 'no' => 'Nő', 'egyeb' => 'Egyéb'];
$erdeklodesErvenyes = ['sport', 'zene', 'olvasas', 'utazas', 'film'];
$lakhelyek          = ['Kolozsvár', 'Csíkszereda', 'Marosvásárhely', 'Nagyvárad', 'Temesvár'];

$nev     = htmlspecialchars($user['nev']     ?? '');
$email   = htmlspecialchars($user['email']   ?? '');
$kor     = (int) ($user['kor']               ?? 0);
$telefon = htmlspecialchars($user['telefon'] ?? '');
$lakhely = htmlspecialchars($lakhely);

if ($submitted) {
    // Nem: whitelist ellenőrzés
    $nem = in_array($nem, array_keys($nemWhitelist)) ? $nem : '';
    // Érdeklődési körök: csak érvényes értékek maradnak
    $erdeklodes = array_intersect($erdeklodes, $erdeklodesErvenyes);
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
    <p><strong>Felhasználónév:</strong> <?= $nev ?></p>
    <p><strong>E-mail:</strong> <?= $email ?></p>
    <p><strong>Életkor:</strong> <?= $kor ?></p>
    <p><strong>Telefon:</strong> <?= $telefon ?></p>
    <p><strong>Nem:</strong> <?= htmlspecialchars($nemWhitelist[$nem] ?? '(nincs megadva)') ?></p>
    <p><strong>Lakhely:</strong> <?= $lakhely ?></p>
    <p><strong>Érdeklődési körök:</strong>
        <?= !empty($erdeklodes) ? htmlspecialchars(implode(', ', $erdeklodes)) : '(nincs)' ?>
    </p>
    <hr>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="user[nev]" value="<?= $nev ?>"></label></p>
    <p><label>E-mail: <input type="email" name="user[email]" value="<?= $email ?>"></label></p>
    <p><label>Életkor: <input type="number" name="user[kor]" value="<?= $kor ?: '' ?>"></label></p>
    <p><label>Telefon: <input type="text" name="user[telefon]" value="<?= $telefon ?>"></label></p>
    <p><label>Jelszó: <input type="password" name="user[jelszo]"></label></p>

    <p>Nem:
        <?php foreach ($nemWhitelist as $ertek => $cimke): ?>
            <label>
                <input type="radio" name="nem" value="<?= $ertek ?>"
                    <?= $nem === $ertek ? 'checked' : '' ?>> <?= $cimke ?>
            </label>
        <?php endforeach; ?>
    </p>

    <p>Érdeklődési körök:
        <?php foreach (['sport' => 'Sport', 'zene' => 'Zene', 'olvasas' => 'Olvasás', 'utazas' => 'Utazás', 'film' => 'Film'] as $ertek => $cimke): ?>
            <label>
                <input type="checkbox" name="erdeklodes[]" value="<?= $ertek ?>"
                    <?= in_array($ertek, $erdeklodes) ? 'checked' : '' ?>> <?= $cimke ?>
            </label>
        <?php endforeach; ?>
    </p>

    <p>
        <label>Lakhely:
            <select name="lakhely">
                <?php foreach ($lakhelyek as $varos): ?>
                    <option value="<?= $varos ?>" <?= $lakhely === $varos ? 'selected' : '' ?>>
                        <?= $varos ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>

    <button type="submit">Regisztráció</button>
</form>

</body>
</html>
