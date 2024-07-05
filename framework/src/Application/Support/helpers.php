<?php

if (!function_exists('env')) {
    function env(string $key, string $default = null): string
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('response')) {
    function response(array $data, int $status = 200): string|bool
    {
        http_response_code($status);
        header('Content-Type: application/json');
        $newData = wrapKeys($data);
        return json_encode(removeNumericKeys($newData));
    }
}

if (!function_exists('json')) {
    function json(string $data): array
    {
        return json_decode($data, true);
    }
}

if (!function_exists('removeNumericKeys')) {
    function removeNumericKeys(array $data): array
    {
        foreach ($data as &$item) {
            foreach ($item as $key => $value) {
                if (is_int($key)) {
                    unset($item[$key]);
                }
            }
        }
        return $data;
    }
}

if (!function_exists('warpKeys')) {
    function wrapKeys(array $data): array
    {
        $wrappedData = [];

        foreach ($data as $item) {
            $newItem = [];
            foreach ($item as $key => $value) {
                // Only wrap non-numeric keys
                if (!is_int($key)) {
                    $newItem['data'][$key] = $value;
                }
            }
            $wrappedData[] = $newItem;
        }

        return $wrappedData;
    }
}