<?php use App\Helpers\ViewHelper; ?>

<label for="title">Cím</label>
<input type="text" id="title" name="title"
       value="<?= ViewHelper::escape($_POST['title'] ?? $film['title'] ?? '') ?>"
       required>

<label for="director">Rendező</label>
<input type="text" id="director" name="director"
       value="<?= ViewHelper::escape($_POST['director'] ?? $film['director'] ?? '') ?>"
       required>

<label for="year">Megjelenési év</label>
<input type="number" id="year" name="year"
       min="1888" max="2100"
       value="<?= ViewHelper::escape($_POST['year'] ?? $film['year'] ?? date('Y')) ?>"
       required>

<label for="genre">Műfaj</label>
<input type="text" id="genre" name="genre"
       value="<?= ViewHelper::escape($_POST['genre'] ?? $film['genre'] ?? '') ?>"
       required>
