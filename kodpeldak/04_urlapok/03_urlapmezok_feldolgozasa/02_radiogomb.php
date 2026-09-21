<?php

// =============================================================
// 4.15. Rádiógomb feldolgozása engedélyezett értékek ellenőrzésével
// =============================================================
?>
<form method="POST">
    <input type="radio" name="gender" value="male"> Férfi
    <input type="radio" name="gender" value="female"> Nő
    <input type="submit" value="Küldés">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowed = ['male', 'female'];
    $gender  = $_POST['gender'] ?? '';

    if (in_array($gender, $allowed, true)) {
        echo "Választott nem: " . htmlspecialchars($gender);
    } else {
        echo "Érvénytelen vagy hiányzó választás.";
    }
}
?>
