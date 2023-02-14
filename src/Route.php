<?php

namespace Remils\Router;

class Route
{
    protected string $method;

    protected string $pattern;

    public function __construct(
        string $method,
        string $pattern,
        protected string $controller,
        protected string $action
    ) {
        $this->method  = strtoupper($method);
        $this->pattern = sprintf('#^%s$#i', trim($pattern, '/'));
    }

    public static function get(string $pattern, string $controller, string $action): static
    {
        return new static('GET', $pattern, $controller, $action);
    }

    public static function post(string $pattern, string $controller, string $action): static
    {
        return new static('POST', $pattern, $controller, $action);
    }

    public static function put(string $pattern, string $controller, string $action): static
    {
        return new static('PUT', $pattern, $controller, $action);
    }

    public static function delete(string $pattern, string $controller, string $action): static
    {
        return new static('DELETE', $pattern, $controller, $action);
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
