<?php

namespace Application\Routing;

use BadMethodCallException;

abstract class Controller
{
    public function __call(string $method, array $arguments)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method));
    }
}