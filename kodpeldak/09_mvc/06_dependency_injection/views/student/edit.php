<?php /* Kiegészítés (nem szerepel a könyvben): szerkesztő nézet a közös űrlaprészlettel */ ?>
<?php use App\Helpers\ViewHelper; ?>

<div class="form-container">
    <h1>Hallgató szerkesztése</h1>

    <form method="POST" action="">
        <?php include __DIR__ . '/../partials/_student_form.php'; ?>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Mentés</button>
            <a href="<?= ViewHelper::url('index') ?>" class="btn btn-secondary">Mégse</a>
        </div>
    </form>
</div>
