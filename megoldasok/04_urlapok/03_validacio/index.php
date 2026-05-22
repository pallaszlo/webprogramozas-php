<?php
$errors  = [];
$success = false;

// Állapotmegőrzéshez: kezdeti értékek
$nev     = '';
$email   = '';
$kor     = '';
$telefon = '';
$nem     = '';
$lakhely = '';

$nemWhitelist = ['ferfi' => 'Férfi', 'no' => 'Nő', 'egyeb' => 'Egyéb'];
$lakhelyek    = ['Kolozsvár', 'Csíkszereda', 'Marosvásárhely', 'Nagyvárad'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filters = [
        'nev'     => FILTER_SANITIZE_SPECIAL_CHARS,
        'email'   => FILTER_VALIDATE_EMAIL,
        'kor'     => [
            'filter'  => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 18, 'max_range' => 99],
        ],
        'telefon' => FILTER_DEFAULT,
        'nem'     => FILTER_DEFAULT,
        'lakhely' => FILTER_DEFAULT,
    ];

    $data = filter_input_array(INPUT_POST, $filters);

    // Állapotmegőrzés: nyers értékek a mezőkbe
    $nev     = htmlspecialchars($_POST['nev']     ?? '');
    $email   = htmlspecialchars($_POST['email']   ?? '');
    $kor     = htmlspecialchars($_POST['kor']     ?? '');
    $telefon = htmlspecialchars($_POST['telefon'] ?? '');
    $nem     = $_POST['nem']     ?? '';
    $lakhely = $_POST['lakhely'] ?? '';

    // Validáció
    if (empty($data['nev'])) {
        $errors[] = 'A név megadása kötelező.';
    }
    if ($data['email'] === false || $data['email'] === null) {
        $errors[] = 'Érvénytelen e-mail cím.';
    }
    if ($data['kor'] === false || $data['kor'] === null) {
        $errors[] = 'Az életkornak 18 és 99 közé kell esnie.';
    }
    if (!empty($data['telefon']) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $data['telefon'])) {
        $errors[] = 'Érvénytelen telefonszám formátum (pl. +40 740 123 456).';
    }
    if (!in_array($nem, array_keys($nemWhitelist))) {
        $errors[] = 'Kérjük, válasszon nemet.';
    }

    if (empty($errors)) {
        $success = true;
    }
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

<?php if ($success): ?>
    <p style="color:green;">Az adatok érvényesek, a regisztráció sikeres!</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $hiba): ?>
            <li><?= htmlspecialchars($hiba) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <p><label>Név: <input type="text" name="nev" value="<?= $nev ?>"></label></p>
    <p><label>E-mail: <input type="text" name="email" value="<?= $email ?>"></label></p>
    <p><label>Életkor (18–99): <input type="number" name="kor" value="<?= $kor ?>"></label></p>
    <p><label>Telefon: <input type="text" name="telefon" value="<?= $telefon ?>" placeholder="+40 740 123 456"></label></p>

    <p>Nem:
        <?php foreach ($nemWhitelist as $ertek => $cimke): ?>
            <label>
                <input type="radio" name="nem" value="<?= $ertek ?>"
                    <?= $nem === $ertek ? 'checked' : '' ?>> <?= $cimke ?>
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
