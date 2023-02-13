<?php

namespace Remils\Router;

class Route
{
    protected string $method;

    protected string $pattern;

    public function __construct(
        $method,
        $pattern,
        protected string $controller,
        protected string $action
    ) {
        $this->method  = strtoupper($method);
        $this->pattern = sprintf('#^%s$#i', trim($pattern, '/'));
    }

    public function method(): string
    {
        return $this->method;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    public function controller(): string
    {
        return $this->controller;
    }

    public function action(): string
    {
        return $this->action;
    }
}
