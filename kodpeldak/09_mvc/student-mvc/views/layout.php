<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Student MVC') ?></title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        nav a { margin-right: 1rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: .5rem 1rem; text-align: left; }
        th { background: #f4f4f4; }
        .alert { background: #d4edda; border: 1px solid #c3e6cb; padding: .75rem; margin: 1rem 0; border-radius: 4px; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: .75rem; margin: 1rem 0; border-radius: 4px; }
        .btn { display: inline-block; padding: .4rem .9rem; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #007bff; color: #fff; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-danger { background: #dc3545; color: #fff; }
        input[type=text], input[type=email] { width: 100%; padding: .4rem; box-sizing: border-box; margin-bottom: .75rem; }
        label { display: block; font-weight: bold; margin-bottom: .25rem; }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/views/partials/nav.php'; ?>

    <main>
        <?php if (isset($message) && $message !== ''): ?>
            <div class="alert"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <?php include BASE_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
