<?php

namespace Application\Routing;

class Request
{
    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
}