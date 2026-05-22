<?php
$method    = $_SERVER['REQUEST_METHOD'];
$uri       = htmlspecialchars($_SERVER['REQUEST_URI']);
$userAgent = htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? '');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Szuperglobális változók</title>
</head>
<body>

<h1>Szuperglobális változók</h1>

<form method="GET" style="display:inline;">
    <input type="hidden" name="get_adat" value="pelda_get">
    <button type="submit">GET küldés</button>
</form>

<form method="POST" style="display:inline;">
    <input type="hidden" name="post_adat" value="pelda_post">
    <button type="submit">POST küldés</button>
</form>

<h2>$_SERVER</h2>
<p><strong>REQUEST_METHOD:</strong> <?= $method ?></p>
<p><strong>REQUEST_URI:</strong> <?= $uri ?></p>
<p><strong>HTTP_USER_AGENT:</strong> <?= $userAgent ?></p>

<h2>$_GET</h2>
<?php if (!empty($_GET)): ?>
    <pre><?= htmlspecialchars(print_r($_GET, true)) ?></pre>
<?php else: ?>
    <p>(üres)</p>
<?php endif; ?>

<h2>$_POST</h2>
<?php if (!empty($_POST)): ?>
    <pre><?= htmlspecialchars(print_r($_POST, true)) ?></pre>
<?php else: ?>
    <p>(üres)</p>
<?php endif; ?>

<h2>$_REQUEST</h2>
<pre><?= htmlspecialchars(print_r($_REQUEST, true)) ?></pre>

</body>
</html>
