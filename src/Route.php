<?php

namespace Remils\Router;

class Route
{
    public function __construct(
        protected string $method,
        protected string $pattern,
        protected string $controller,
        protected string $action
    ) {
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
