<?php

// =============================================================
// 3.53. Autoloader regisztrálása (autoloader.php)
// =============================================================

spl_autoload_register(function (string $className): void {
    $file = 'classes/' . $className . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
