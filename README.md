# Borsch - Router

A simple router implementation inspired by [Mezzio](https://docs.mezzio.dev/mezzio/).

This package is part of the Borsch Framework.

## Installation

Via [composer](https://getcomposer.org/) :

`composer require borsch/router`

## Usage

```php
require_once __DIR__.'/vendor/autoload.php';

use Borsch\Router\UriTemplateRouter;

$router = new UriTemplateRouter();

$router->get(
    '/hotels/{hotel}/bookings/{booking}',
    function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
        // Laminas\Diactoros\Response or any other PSR-7 implementation. 
        $response = new \Laminas\Diactoros\Response();
        $response->getBody()->write('Welcome to the hotel page !');
        return $response;
    },
    'route-name'
);

$server_request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals();
$route_result = $router->match($server_request);
// $route_result is an instance of RouteResultInterface.
```

## License

The package is licensed under the MIT license. See [License File](https://github.com/debuss/borsch-router/blob/master/LICENSE.md) for more information.