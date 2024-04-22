<?php

namespace Application\Support;

use Dotenv\Dotenv;

class Env
{
    protected Dotenv $env;

    public function __construct()
    {
        $this->env = Dotenv::createImmutable(__DIR__ . '/../../../../');
        $this->env->load();
        return $this;
    }
}