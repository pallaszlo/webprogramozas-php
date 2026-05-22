<?php use App\Helpers\ViewHelper; ?>

<h1>Új hallgató létrehozása</h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= ViewHelper::escape($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <label for="name">Név</label>
    <input type="text" id="name" name="name"
           value="<?= ViewHelper::escape($_POST['name'] ?? '') ?>"
           required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email"
           value="<?= ViewHelper::escape($_POST['email'] ?? '') ?>"
           required>

    <button type="submit" class="btn btn-primary">Létrehozás</button>
    <a class="btn btn-secondary" href="index.php?action=index">Mégse</a>
</form>
