<?php use App\Helpers\ViewHelper; ?>

<h1>Film szerkesztése</h1>

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
    <?php include BASE_PATH . '/views/partials/_film_form.php'; ?>

    <button type="submit" class="btn btn-primary">Mentés</button>
    <a class="btn btn-secondary" href="index.php?action=index">Mégse</a>
</form>
