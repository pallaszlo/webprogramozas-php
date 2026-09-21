<?php
// A 2. feladat regisztrációs űrlapja szerveroldali validációval

$nemek       = ['ferfi' => 'Férfi', 'no' => 'Nő'];
$erdeklodesi = ['sport' => 'Sport', 'zene' => 'Zene', 'olvasas' => 'Olvasás', 'utazas' => 'Utazás', 'film' => 'Film'];
$lakhelyek   = ['Kolozsvár', 'Csíkszereda', 'Marosvásárhely', 'Nagyvárad', 'Temesvár'];

$errors  = [];
$success = false;

// Állapotmegőrzéshez: a mezők kezdeti értékei (nyers szöveg, kódolás csak kiíráskor)
$name       = '';
$email      = '';
$age        = '';
$phone      = '';
$nem        = '';
$erdeklodes = [];
$lakhely    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. A legfelső szintű mezők beolvasása. A user[...] és az erdeklodes[] tömbként érkezik.
    $post = filter_input_array(INPUT_POST, [
        'user'       => ['filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY],
        'nem'        => FILTER_DEFAULT,
        'erdeklodes' => ['filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY],
        'lakhely'    => FILTER_DEFAULT,
    ]) ?? [];

    // 2. A user[...] tömb elemeinek szűrése mezőnként
    $user = filter_var_array(is_array($post['user'] ?? null) ? $post['user'] : [], [
        'name'  => FILTER_DEFAULT,
        'email' => FILTER_VALIDATE_EMAIL,
        'age'   => [
            'filter'  => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 18, 'max_range' => 99],
        ],
        'phone' => FILTER_DEFAULT,
    ]);

    // Állapotmegőrzés: a beküldött (nyers) értékek visszakerülnek a mezőkbe
    $raw        = (array) ($_POST['user'] ?? []);
    $name       = trim($raw['name']  ?? '');
    $email      = trim($raw['email'] ?? '');
    $age        = trim($raw['age']   ?? '');
    $phone      = trim($raw['phone'] ?? '');
    $nem        = is_string($post['nem'] ?? null) ? $post['nem'] : '';
    $erdeklodes = is_array($post['erdeklodes'] ?? null) ? $post['erdeklodes'] : [];
    $lakhely    = is_string($post['lakhely'] ?? null) ? $post['lakhely'] : '';

    // 3. Validáció: a hibákat egy tömbben gyűjtjük
    if ($name === '') {
        $errors[] = 'A felhasználónév megadása kötelező.';
    }
    if ($user['email'] === false || $user['email'] === null) {
        $errors[] = 'Érvénytelen e-mail-cím.';
    }
    if ($user['age'] === false || $user['age'] === null) {
        $errors[] = 'Az életkornak 18 és 99 közötti egész számnak kell lennie.';
    }
    if (!preg_match('/^\+?[0-9 \-]{7,15}$/', $phone)) {
        $errors[] = 'Érvénytelen telefonszám-formátum (pl. +40 740 123 456).';
    }
    if (mb_strlen($raw['password'] ?? '') < 8) {
        $errors[] = 'A jelszónak legalább 8 karakter hosszúnak kell lennie.';
    }
    if (!array_key_exists($nem, $nemek)) {
        $errors[] = 'Válasszon nemet.';
    }
    if (array_diff($erdeklodes, array_keys($erdeklodesi))) {
        $errors[] = 'Érvénytelen érdeklődési kör.';
    }
    if (!in_array($lakhely, $lakhelyek, true)) {
        $errors[] = 'Válasszon lakhelyet a listából.';
    }

    $success = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció – validációval</title>
</head>
<body>

<h1>Regisztráció – szerveroldali validáció</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $hiba): ?>
            <li><?= htmlspecialchars($hiba) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;">Az adatok érvényesek, a regisztráció sikeres!</p>
<?php endif; ?>

<form method="POST">
    <p><label>Felhasználónév: <input type="text" name="user[name]" value="<?= htmlspecialchars($name) ?>"></label></p>
    <p><label>E-mail: <input type="text" name="user[email]" value="<?= htmlspecialchars($email) ?>"></label></p>
    <p><label>Életkor (18–99): <input type="number" name="user[age]" value="<?= htmlspecialchars($age) ?>"></label></p>
    <p><label>Telefon: <input type="text" name="user[phone]" value="<?= htmlspecialchars($phone) ?>" placeholder="+40 740 123 456"></label></p>
    <p><label>Jelszó (legalább 8 karakter): <input type="password" name="user[password]"></label></p>

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
