<?php

// =============================================================
// 9.16. ViewHelper segédosztály
// =============================================================

namespace App\Helpers;

class ViewHelper
{
    /**
     * HTML-kódolás XSS elleni védelemhez
     */
    public static function escape(mixed $var): string
    {
        if (is_null($var)) {
            return '';
        }
        return htmlspecialchars((string)$var,
                               ENT_QUOTES, 'UTF-8');
    }

    /**
     * URL generálás
     */
    public static function url(string $action,
                              array $params = []): string
    {
        $url = 'index.php?action=' . urlencode($action);

        foreach ($params as $key => $value) {
            $url .= '&' . urlencode((string)$key) .
                    '=' . urlencode((string)$value);
        }

        return $url;
    }

    // További helper metódusok...
}
