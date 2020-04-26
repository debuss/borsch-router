<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BasePathRouter
 * @package Borsch\Router
 */
class BasePathRouter extends AbstractRouter
{

    use HttpMethodTrait;

    /**
     * @inheritDoc
     */
    public function match(ServerRequestInterface $request): RouteResultInterface
    {
        foreach ($this->routes as $route) {
            if (strpos($request->getUri()->getPath(), $route->getPath()) === 0) {
                if (in_array($request->getMethod(), $route->getAllowedMethods())) {
                    return RouteResult::fromRoute($route, []);
                }

                return RouteResult::fromRouteFailure($route->getAllowedMethods());
            }
        }

        return RouteResult::fromRouteFailure([]);
    }

    /**
     * @inheritDoc
     */
    public function generateUri(string $name, array $substitutions = []): string
    {
        if (!isset($this->routes[$name])) {
            return '';
        }

        return $this->routes[$name]->getPath();
    }
}
