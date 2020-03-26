<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BasePathRouter
 */
class BasePathRouter implements RouterInterface
{

    use HttpMethodTrait;

    /** @var RouteInterface[]  */
    protected $routes = [];

    /**
     * @inheritDoc
     */
    public function addRoute(RouteInterface $route): void
    {
        $this->routes[] = $route;
    }

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
    public function generateUri(string $name, array $substitutions = [], array $options = []): string
    {
        foreach ($this->routes as $route) {
            if ($route->getName() == $name) {
                return $route->getPath();
            }
        }

        return '';
    }
}
