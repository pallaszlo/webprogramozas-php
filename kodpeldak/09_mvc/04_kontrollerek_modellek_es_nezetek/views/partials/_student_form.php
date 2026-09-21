<?php /* 9.17. Újrafelhasználható form részlet (_student_form.php) */ ?>
<?php use App\Helpers\ViewHelper; ?>

<div class="form-group">
    <label for="name">Név *</label>
    <input
        type="text"
        id="name"
        name="name"
        value="<?= ViewHelper::escape($student['name'] ?? '') ?>"
        required
    >
</div>

<div class="form-group">
    <label for="email">Email cím *</label>
    <input
        type="email"
        id="email"
        name="email"
        value="<?= ViewHelper::escape($student['email'] ?? '') ?>"
        required
    >
</div>

<!-- További mezők... -->
