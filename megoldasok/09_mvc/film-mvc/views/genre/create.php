<?php use App\Helpers\ViewHelper; ?>

<h1>Új műfaj</h1>

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

    <button type="submit" class="btn btn-primary">Hozzáadás</button>
    <a class="btn btn-secondary" href="<?= ViewHelper::url('genres') ?>">Mégse</a>
</form>
