<?php

// =============================================================
// 4.17. Többválasztásos jelölőnégyzet feldolgozása
// =============================================================
?>
<form method="POST">
    <input type="checkbox" name="fruits[]" value="apple" /> Alma
    <input type="checkbox" name="fruits[]" value="banana" /> Banán
    <input type="checkbox" name="fruits[]" value="orange" /> Narancs
    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fruits = $_POST['fruits'] ?? [];

    if (!empty($fruits)) {
        $safeFruits = array_map('htmlspecialchars', $fruits);
        echo "Választott gyümölcsök: " . implode(", ", $safeFruits);
    } else {
        echo "Nem választott gyümölcsöt.";
    }
}
?>
