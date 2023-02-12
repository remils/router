# Router

## Install

```ssh
composer require remils/router
```

## Use

```php
<?php

require './vendor/autoload.php';

use Remils\Router\Route;
use Remils\Router\Router;

class BlogController
{
    public function posts(): void
    {
        echo 'Posts' . PHP_EOL;
    }

    public function post(int $id): void
    {
        echo 'Post ' . $id . PHP_EOL;
    }
}

class Kernel
{
    protected Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function registerRoutes(array $routes): static
    {
        foreach ($routes as $route) {
            $this->router->add($route);
        }

        return $this;
    }

    public function handle(array $request): void
    {
        $dispatch = $this->router->match($request['method'], $request['url']);

        if ($dispatch) {
            $reflectionClass = new ReflectionClass($dispatch->route()->controller());
            $instance        = $reflectionClass->newInstanceArgs();

            call_user_func([$instance, $dispatch->route()->action()], ...$dispatch->matches());
        }
    }
}

$routes = [
    new Route('GET', '/posts', BlogController::class, 'posts'),
    new Route('GET', '/posts/(\d+)', BlogController::class, 'post'),
];

$kernel = new Kernel();
$kernel->registerRoutes($routes);

$kernel->handle([
    'method' => 'GET',
    'url'    => '/posts'
]); // Posts

$kernel->handle([
    'method' => 'GET',
    'url'    => '/posts/1995'
]); // Post 1995

$kernel->handle([
    'method' => 'GET',
    'url'    => '/posts/slug'
]); //
```

## License

Copyright (c) Zatulivetrov Sergey. Distributed under the MIT.
