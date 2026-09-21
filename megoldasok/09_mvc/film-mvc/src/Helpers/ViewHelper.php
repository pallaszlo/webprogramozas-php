<?php

namespace App\Helpers;

/** A nézetekben használt segédfüggvények. */
class ViewHelper
{
    /** HTML-kódolás az XSS elleni védelemhez. */
    public static function escape(mixed $var): string
    {
        if ($var === null) {
            return '';
        }
        return htmlspecialchars((string)$var, ENT_QUOTES, 'UTF-8');
    }

    /** URL előállítása az action és az opcionális paraméterek alapján. */
    public static function url(string $action, array $params = []): string
    {
        $url = 'index.php?action=' . urlencode($action);

        foreach ($params as $key => $value) {
            $url .= '&' . urlencode((string)$key)
                  . '=' . urlencode((string)$value);
        }

        return $url;
    }
}
