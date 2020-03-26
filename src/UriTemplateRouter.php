<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use League\Uri\Contracts\UriException;
use League\Uri\UriTemplate;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UriTemplateRouter
 */
class UriTemplateRouter implements RouterInterface
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

    /**
     * @inheritDoc
     */
    public function generateUri(string $name, array $substitutions = [], array $options = []): string
    {
        foreach ($this->routes as $route) {
            if ($route->getName() == $name) {
                $template = new UriTemplate($route->getPath());

                try {
                    $uri = $template->expand($substitutions);
                } catch (UriException $exception) {
                    $uri = '';
                } finally {
                    return (string)$uri;
                }
            }
        }

        return '';
    }
}
