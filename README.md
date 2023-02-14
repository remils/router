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
    public function index(): void
    {
        echo 'Posts' . PHP_EOL;
    }

    public function create(): void
    {
        echo 'Create post' . PHP_EOL;
    }

    public function show(int $id): void
    {
        echo 'Show post ' . $id . PHP_EOL;
    }

    public function update(int $id): void
    {
        echo 'Update post ' . $id . PHP_EOL;
    }

    public function delete(int $id): void
    {
        echo 'Delete post ' . $id . PHP_EOL;
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

    public function handle(): void
    {
        $dispatch = $this->router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        if ($dispatch) {
            $controller = $dispatch->route()->controller();
            $action     = $dispatch->route()->action();
            $matches    = $dispatch->matches();

            $reflectionClass = new ReflectionClass($controller);
            $instance        = $reflectionClass->newInstanceArgs();

            $reflectionMethod = new ReflectionMethod($controller, $action);
            $reflectionMethod->invokeArgs($instance, $matches);
        }
    }
}

$routes = [
    Route::get('/posts', BlogController::class, 'index'),
    Route::post('/posts', BlogController::class, 'create'),
    Route::get('/posts/(\d+)', BlogController::class, 'show'),
    Route::put('/posts/(\d+)', BlogController::class, 'update'),
    Route::delete('/posts/(\d+)', BlogController::class, 'delete'),
];

$kernel = new Kernel();
$kernel->registerRoutes($routes);

// $_SERVER['REQUEST_METHOD'] = 'GET';
// $_SERVER['REQUEST_URI']    = '/posts/1995';

$kernel->handle();
```

## License

Copyright (c) Zatulivetrov Sergey. Distributed under the MIT.
