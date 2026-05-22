<?php
if (isset($_POST['mentes'])) {
    // HttpOnly: JavaScript nem érheti el
    // Secure: csak HTTPS-en (localhost-on nem érvényesül)
    // SameSite: CSRF védelem
    setcookie('biztonsagos_suti', 'titkos_ertek', [
        'expires'  => time() + 3600,
        'path'     => '/',
        'secure'   => false,   // HTTPS esetén: true
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    setcookie('lax_suti', 'lax_ertek', [
        'expires'  => time() + 3600,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    setcookie('alap_suti', 'alap_ertek', [
        'expires' => time() + 3600,
        'path'    => '/',
        // Nincs httponly, nincs samesite
    ]);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Sütik biztonsági beállításai</title>
</head>
<body>

<h1>Biztonsági attribútumok demonstrációja</h1>

<form method="POST">
    <button type="submit" name="mentes" value="1">Sütik beállítása</button>
</form>

<h2>Sütik JavaScriptből (document.cookie)</h2>
<p>A <code>httponly</code> sütik <strong>nem láthatók</strong> JavaScriptből:</p>
<pre id="js-cookies"></pre>
<script>
    document.getElementById('js-cookies').textContent = document.cookie || '(üres)';
</script>

<h2>$_COOKIE (PHP oldalon)</h2>
<pre><?= htmlspecialchars(print_r($_COOKIE, true)) ?></pre>

<h2>Beállított sütik és attribútumaik</h2>
<table border="1" cellpadding="5">
    <tr><th>Süti</th><th>HttpOnly</th><th>SameSite</th><th>Secure</th></tr>
    <tr><td>biztonsagos_suti</td><td>igen</td><td>Strict</td><td>nem (demo)</td></tr>
    <tr><td>lax_suti</td><td>igen</td><td>Lax</td><td>nem</td></tr>
    <tr><td>alap_suti</td><td>nem</td><td>nincs</td><td>nem</td></tr>
</table>

</body>
</html>
