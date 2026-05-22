<?php

namespace App\Core;

abstract class BaseController
{
    public function __construct(protected BaseModel $model) {}

    protected function render(string $view,
                              array $data = [],
                              bool $layout = true): void
    {
        $viewFile = BASE_PATH . "/views/{$view}.php";

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View nem található: {$viewFile}");
        }

        // Az extract() a $data tömb kulcsait változóként elérhetővé teszi a nézetben
        ob_start();
        extract($data);
        include $viewFile;
        $content = ob_get_clean();

        if ($layout) {
            include BASE_PATH . '/views/layout.php';
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
