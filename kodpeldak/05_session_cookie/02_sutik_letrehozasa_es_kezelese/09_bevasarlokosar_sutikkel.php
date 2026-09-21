<?php

// =============================================================
// 5.13. Bevásárlókosár sütikkel
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
// a termékek ára (valós alkalmazásban adatbázisból érkezik)
$termekArak = [1 => 1500, 2 => 2500];


// Kosár betöltése sütiből
$kosar = isset($_COOKIE['kosar'])
    ? json_decode($_COOKIE['kosar'], true) ?? []
    : [];

// Termék hozzáadása
if (isset($_POST['hozzaad'])) {
    $termekId = (int) $_POST['termek_id'];

    $kosar[$termekId] = ($kosar[$termekId] ?? 0) + 1;

    setcookie('kosar', json_encode($kosar), [
        'expires' => time() + 86400,
        'path'    => '/'
    ]);
}

// Termék eltávolítása
if (isset($_POST['torol'])) {
    $termekId = (int) $_POST['termek_id'];

    unset($kosar[$termekId]);

    setcookie('kosar', json_encode($kosar), [
        'expires' => time() + 86400,
        'path'    => '/'
    ]);
}

// Kosár kiírása (példaárakkal)
foreach ($kosar as $termekId => $darab) {
    $ar = $termekArak[$termekId] ?? 0;

    echo "Termék #$termekId: $darab db - "
        . number_format($ar * $darab, 2)
        . " RON<br>";
}
?>

<!-- Kiegészítés (nem szerepel a könyvben): űrlap a kipróbáláshoz -->
<?php foreach ([1, 2] as $id): ?>
    <form method="POST" style="display:inline">
        <input type="hidden" name="termek_id" value="<?= $id ?>">
        <button type="submit" name="hozzaad">#<?= $id ?> kosárba</button>
        <button type="submit" name="torol">#<?= $id ?> törlése</button>
    </form>
<?php endforeach; ?>
