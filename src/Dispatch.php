<?php

namespace Remils\Router;

class Dispatch
{
    public function __construct(
        protected Route $route,
        protected array $matches,
    ) {
    }

    public function route(): Route
    {
        return $this->route;
    }

    public function matches(): array
    {
        return $this->matches;
    }
}
