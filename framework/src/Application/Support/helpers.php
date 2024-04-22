<?php

use eftec\bladeone\BladeOne;

if (!function_exists('env')) {
    function env(string $key, string $default = null): string
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('resource_path')) {
    function resource_path(string $path = '')
    {
        return require_once __DIR__ . '/../../../../resources/' . $path;
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        $storagePath = __DIR__ . '/../../../../storage/' . $path;

        // Check if the storage path exists
        if (!file_exists($storagePath)) {
            // if not, create the storage path
            mkdir($storagePath, 0777, true);
        }

        return require_once $storagePath;
    }
}

if (!function_exists('view')) {
    function view(string $view, array|null $data)
    {
        // convert dot notation to slash notation
        $convertViewDotToSlashNotation = str_replace('.', '/', $view);
        $viewDir = resource_path('views/' . $convertViewDotToSlashNotation . '.blade.php');

        $storageDir = storage_path('framework/views/');

        $blade = new BladeOne($viewDir, $storageDir, BladeOne::MODE_DEBUG);

        // Compile all blade files in the views directory
        $blade->compile($viewDir, $storageDir);

        return $blade->run($convertViewDotToSlashNotation, compact($data));
    }
}
