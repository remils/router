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

    public function handle(): void
    {
        $dispatch = $this->router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        if ($dispatch) {
            $controller = $dispatch->route()->controller();
            $action     = $dispatch->route()->action();
            $matches    = $dispatch->matches();

            $reflectionClass = new ReflectionClass($controller);
            $instance        = $reflectionClass->newInstanceArgs();

            call_user_func_array([$instance, $action], $matches);
        }
    }
}

$routes = [
    new Route('GET', '/posts', BlogController::class, 'posts'),
    new Route('GET', '/posts/(\d+)', BlogController::class, 'post'),
];

$kernel = new Kernel();
$kernel->registerRoutes($routes);

// $_SERVER['REQUEST_METHOD'] = 'GET';
// $_SERVER['REQUEST_URI']    = '/posts/1995?filter=one';

$kernel->handle();
```

## License

Copyright (c) Zatulivetrov Sergey. Distributed under the MIT.
