<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $viewPath, array $data = [], string $layout = 'layouts/public'): string
    {
        $baseViewDir = dirname(__DIR__, 2) . '/views';
        $viewFile = "{$baseViewDir}/" . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View file not found: {$viewFile}");
        }

        // Ensure request instance is always available in views
        $data['request'] = $data['request'] ?? request();

        // Extract variables to scope
        extract($data, EXTR_SKIP);

        // Capture view output
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if ($layout === '' || $layout === null) {
            return $content;
        }

        $layoutFile = "{$baseViewDir}/" . str_replace('.', '/', $layout) . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout file not found: {$layoutFile}");
        }

        ob_start();
        include $layoutFile;
        return ob_get_clean();
    }
}
