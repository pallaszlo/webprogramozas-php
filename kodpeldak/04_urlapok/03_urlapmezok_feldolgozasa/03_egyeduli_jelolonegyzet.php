<?php

// =============================================================
// 4.16. Egyetlen jelölőnégyzet feldolgozása
// =============================================================
?>
<form method="POST">
    <input type="checkbox" name="agree" value="1" /> Elfogadom a feltételeket
    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agree']) && $_POST['agree'] === '1') {
        echo "Elfogadta a feltételeket";
    } else {
        echo "Nem fogadta el a feltételeket";
    }
}
?>
