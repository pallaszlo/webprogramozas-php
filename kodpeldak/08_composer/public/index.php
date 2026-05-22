<?php
// Indítás: composer install, majd: php public/index.php

require __DIR__ . '/../vendor/autoload.php';

use App\Logger;

// A logs mappa létrehozása, ha még nem létezik
if (!is_dir(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);
}

$logger = new Logger();
$logger->info('Az alkalmazás elindult');
$logger->error('Példa hibaüzenet');

echo "Naplózás sikeres. Ellenőrizd a logs/app.log fájlt." . PHP_EOL;
