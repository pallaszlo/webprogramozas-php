<?php

// =============================================================
// 4.14. Szöveges mező feldolgozása
// =============================================================
?>
<form method="POST">
    <input type="text" name="username" />
    <textarea name="comment"></textarea>
    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $comment  = $_POST['comment'] ?? '';

    echo "Felhasználónév: " . htmlspecialchars($username) . "<br>";
    echo "Megjegyzés: " . htmlspecialchars($comment);
}
?>
