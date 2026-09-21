<?php

// =============================================================
// 3.15. Hibakezelés és kivételkezelés
// =============================================================


// --- 3.60. Saját hibakezelő függvény -------------------------
function customErrorHandler(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
): bool
{
    switch ($errno) {
        case E_USER_ERROR:
            error_log("[$errno] $errstr in $errfile:$errline");
            exit(1);

        case E_USER_WARNING:
            error_log("Warning [$errno]: $errstr");
            break;

        case E_USER_NOTICE:
            error_log("Notice [$errno]: $errstr");
            break;

        default:
            error_log("Unknown error [$errno]: $errstr");
            break;
    }

    return true; // a beépített hibakezelő ne fusson le
}

set_error_handler('customErrorHandler');

trigger_error('Teszthiba', E_USER_WARNING);
