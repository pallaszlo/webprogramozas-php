<?php
$errors  = [];
$success = false;
$data    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filters = [
        'nev'     => FILTER_SANITIZE_SPECIAL_CHARS,
        'email'   => FILTER_VALIDATE_EMAIL,
        'kor'     => [
            'filter'  => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 18, 'max_range' => 99],
        ],
        'telefon' => FILTER_DEFAULT,
    ];

    $data = filter_input_array(INPUT_POST, $filters);

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
        $errors[] = 'Érvénytelen telefonszám formátum.';
    }

    if (empty($errors)) {
        $success = true;
    }
}

// Állapotmegőrzés: mezők értéke hiba esetén megmarad
$nev     = htmlspecialchars($_POST['nev']     ?? '');
$email   = htmlspecialchars($_POST['email']   ?? '');
$kor     = htmlspecialchars($_POST['kor']     ?? '');
$telefon = htmlspecialchars($_POST['telefon'] ?? '');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Validáció – filter_input_array</title>
</head>
<body>

<h1>Szerveroldali validáció</h1>

<?php if ($success): ?>
    <p style="color:green;">Az adatok érvényesek!</p>
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
    <button type="submit">Ellenőrzés</button>
</form>

</body>
</html>
