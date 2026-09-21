<?php

// =============================================================
// 5.20. Bevásárlókosár kezelése munkamenettel
// =============================================================

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Termék hozzáadása
if (isset($_POST['add_to_cart'])) {
    $id  = (int)($_POST['product_id'] ?? 0);
    $qty = max(1, (int)($_POST['quantity'] ?? 1));

    if ($id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    }
}

// Termék eltávolítása
if (isset($_POST['remove_from_cart'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    unset($_SESSION['cart'][$id]);
}
?>

<!-- Termék hozzáadása -->
<form method="POST">
    <input type="hidden" name="product_id" value="1">
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit" name="add_to_cart">Kosárba</button>
</form>

<!-- Kosár tartalma -->
<?php
$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {
    $price    = 10; // valós alkalmazásban adatbázisból érkezik
    $subtotal = $price * $qty;
    $total   += $subtotal;

    echo "Termék #" . (int)$id . ": " . (int)$qty . " db - " . number_format($subtotal, 2) . " RON";

    echo '<form method="POST" style="display:inline">';
    echo '<input type="hidden" name="product_id" value="' . (int)$id . '">';
    echo '<button type="submit" name="remove_from_cart">Törlés</button>';
    echo '</form><br>';
}

echo "Összesen: " . number_format($total, 2) . " RON";
?>
