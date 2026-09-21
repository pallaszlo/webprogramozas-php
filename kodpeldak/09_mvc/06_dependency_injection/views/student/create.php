<?php /* 9.18. Létrehozó nézet (create.php) */ ?>
<?php use App\Helpers\ViewHelper; ?>

<div class="form-container">
    <h1>Új hallgató létrehozása</h1>

    <form method="POST" action="">
        <?php include __DIR__ . '/../partials/_student_form.php'; ?>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Létrehozás
            </button>
            <a href="<?= ViewHelper::url('index') ?>"
               class="btn btn-secondary">
                Mégse
            </a>
        </div>
    </form>
</div>
