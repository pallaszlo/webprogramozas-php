<?php

// ============================================================
// Autoloader regisztrálása spl_autoload_register() segítségével
// Az osztály neve alapján keresi a fájlt a classes/ mappában
// ============================================================

spl_autoload_register(function (string $className): void {
    $file = __DIR__ . '/classes/' . $className . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
