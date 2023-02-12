<?php

namespace Remils\Router;

class Router
{
    protected array $routes = [];

    public function add(Route $route): static
    {
        $this->routes[] = $route;

        return $this;
    }

    public function match(string $method, string $url): ?Dispatch
    {
        foreach ($this->routes as $route) {
            /** @var Route $route */

            if ($route->method() !== $method) {
                continue;
            }

            $pattern = sprintf('#^%s$#i', $route->pattern());

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);

                return new Dispatch($route, $matches);
            }
        }

        return null;
    }
}
