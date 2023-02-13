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

    public function match(string $method, string $uri): ?Dispatch
    {
        $method = strtoupper($method);
        $url    = trim(substr($uri, 0, strpos($uri, '?')), '/');

        foreach ($this->routes as $route) {
            /** @var Route $route */

            if ($route->method() !== $method) {
                continue;
            }

            if (preg_match($route->pattern(), $url, $matches)) {
                array_shift($matches);

                return new Dispatch($route, $matches);
            }
        }

        return null;
    }
}
