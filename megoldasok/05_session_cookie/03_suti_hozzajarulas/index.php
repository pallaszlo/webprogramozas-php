<?php
// Elfogadás rögzítése
if (isset($_POST['elfogad'])) {
    setcookie('suti_hozzajarulas', '1', [
        'expires' => time() + 86400 * 365,
        'path'    => '/',
    ]);
    header('Location: index.php');
    exit;
}

$hozzajarult = isset($_COOKIE['suti_hozzajarulas']);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Süti hozzájárulás</title>
    <style>
        .suti-sav {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #333; color: #fff;
            padding: 1em 2em;
            display: flex; justify-content: space-between; align-items: center;
        }
        .suti-sav button {
            background: #4CAF50; color: white;
            border: none; padding: 0.5em 1.5em; cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Weboldal tartalma</h1>
<p>Ez az oldal sütiket használ a felhasználói élmény javítása érdekében.</p>

<?php if ($hozzajarult): ?>
    <p style="color:green;">✓ Elfogadtad a sütiket — a sáv többet nem jelenik meg.</p>
<?php else: ?>
    <div class="suti-sav">
        <span>Ez az oldal sütiket használ. A böngészés folytatásával elfogadod azok használatát.</span>
        <form method="POST">
            <button type="submit" name="elfogad" value="1">Elfogadom</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>
