<?php

// =============================================================
// 4.18. Legördülő lista feldolgozása
// =============================================================
?>
<form method="POST">
    <select name="country">
        <option value="usa">USA</option>
        <option value="uk">UK</option>
        <option value="canada">Kanada</option>
    </select>

    <select name="languages[]" multiple>
        <option value="en">Angol</option>
        <option value="fr">Francia</option>
        <option value="de">Német</option>
    </select>

    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country   = htmlspecialchars($_POST['country'] ?? '');
    $languages = $_POST['languages'] ?? [];

    $safeLanguages = array_map('htmlspecialchars', $languages);

    echo "Választott ország: $country<br>";
    echo "Beszélt nyelvek: " . implode(", ", $safeLanguages);
}
?>
