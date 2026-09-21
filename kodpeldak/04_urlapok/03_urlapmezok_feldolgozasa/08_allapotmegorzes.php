<?php

// =============================================================
// 4.21–4.22. Állapotmegőrzés
// =============================================================


// --- 4.21. Állapotmegőrzés -----------------------------------

$formData = ['username' => '', 'interests' => [], 'bio' => ''];
$errors   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['username']  = trim($_POST['username'] ?? '');
    $formData['interests'] = $_POST['interests'] ?? [];
    $formData['bio']       = trim($_POST['bio'] ?? '');

    if (empty($formData['username'])) {
        $errors['username'] = 'A felhasználónév megadása kötelező.';
    }
}
?>

<!-- --- 4.22. Állapotmegőrzés (HTML rész) ------------- -->

<!-- Kiegészítés (nem szerepel a könyvben): a hibaüzenetek kiírása -->
<?php foreach ($errors as $error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>

<form method="POST">
    <!-- Szöveges mező: value attribútumban -->
    <input type="text" name="username"
           value="<?= htmlspecialchars($formData['username']) ?>">

    <!-- Jelölőnégyzet: checked attribútum feltételesen -->
    <input type="checkbox" name="interests[]" value="sport"
           <?= in_array('sport', $formData['interests'], true) ? 'checked' : '' ?>> Sport

    <!-- Textarea: tartalom a tagek között -->
    <textarea name="bio"><?= htmlspecialchars($formData['bio']) ?></textarea>

    <input type="submit" value="Küldés">
</form>
