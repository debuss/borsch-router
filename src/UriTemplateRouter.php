<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UriTemplateRouter
 * @package Borsch\Router
 */
class UriTemplateRouter extends AbstractRouter
{

    use HttpMethodTrait;

    /**
     * @inheritDoc
     */
    public function match(ServerRequestInterface $request): RouteResultInterface
    {
        foreach ($this->routes as $route) {
            if (substr_count($route->getPath(), '/') != substr_count($request->getUri()->getPath(), '/')) {
                continue;
            }

            $user_route_segments = explode('/', $route->getPath());
            $request_route_segments = explode('/', $request->getUri()->getPath());
            $params = [];

            foreach ($user_route_segments as $key => $segment) {
                if ($segment[0] != '{' && $request_route_segments[$key] != $segment) {
                    continue 2;
                }

                if ($segment[0] == '{') {
                    $params[trim($segment, '{}')] = $request_route_segments[$key];
                }
            }

            if (in_array($request->getMethod(), $route->getAllowedMethods())) {
                return RouteResult::fromRoute($route, $params);
            }

            return RouteResult::fromRouteFailure($route->getAllowedMethods());
        }

        return RouteResult::fromRouteFailure([]);
    }
}
