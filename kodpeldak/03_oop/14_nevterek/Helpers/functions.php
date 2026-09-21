<?php

// Kiegészítés (nem szerepel a könyvben): a 3.58. kódpéldában importált függvény

namespace MyProject\Helpers;

function formatDate(string $date): string
{
    return date('Y. m. d.', strtotime($date));
}
