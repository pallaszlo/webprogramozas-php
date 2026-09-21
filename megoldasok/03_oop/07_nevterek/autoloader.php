<?php

// Névtér → fájlrendszer leképezés:
// App\Models\Product   → App/Models/Product.php
// App\Payment\Payment  → App/Payment/Payment.php

spl_autoload_register(function (string $class): void {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
