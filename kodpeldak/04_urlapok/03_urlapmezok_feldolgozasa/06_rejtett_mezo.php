<?php

// =============================================================
// 4.19. Rejtett mező feldolgozása
// =============================================================
?>
<form method="POST">
    <input type="hidden" name="user_id" value="12345" />
    <input type="text" name="comment" placeholder="Írjon kommentet" />
    <input type="submit" value="Küldés" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId  = htmlspecialchars($_POST['user_id'] ?? '');
    $comment = htmlspecialchars($_POST['comment'] ?? '');

    echo "Felhasználó azonosító: $userId<br>";
    echo "Komment: $comment";
}
?>
