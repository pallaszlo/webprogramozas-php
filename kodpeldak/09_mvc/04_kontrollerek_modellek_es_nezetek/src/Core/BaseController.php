<?php

// =============================================================
// 9.11. BaseController osztály
// =============================================================

namespace App\Core;

abstract class BaseController
{
    public function __construct(protected BaseModel $model) {}

    protected function render(string $view,
                             array $data = [],
                             bool $layout = true): void
    {
        $viewFile = __DIR__ . "/../../views/{$view}.php";

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Nézet nem található: {$viewFile}");
        }

        // Output buffering - view tartalmát elkapjuk
        // Az extract() a $data tömb kulcsait változóként elérhetővé teszi a nézetben
        ob_start();
        extract($data);
        include $viewFile;
        $content = ob_get_clean();

        // Layout használata
        if ($layout) {
            include __DIR__ . '/../../views/layout.php';
        } else {
            echo $content;
        }
    }

    protected function redirect(string $action,
                               ?string $message = null,
                               array $params = []): void
    {
        $url = "index.php?action={$action}";

        if ($message !== null) {
            $url .= '&message=' . urlencode($message);
        }

        foreach ($params as $key => $value) {
            $url .= '&' . urlencode((string)$key) . '=' . urlencode((string)$value);
        }

        header("Location: {$url}");
        exit;
    }
}
