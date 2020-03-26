<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class RouteResult
 */
class RouteResult implements RouteResultInterface
{

    /** @var Route */
    protected $route;

    /** @var array */
    protected $params;

    /** @var bool */
    protected $success;

    /** @var array */
    protected $methods;

    /**
     * RouteResult constructor.
     */
    private function __construct() {}

    /**
     * @param RouteInterface $route
     * @param array $params
     * @return RouteResultInterface
     */
    public static function fromRoute(RouteInterface $route, array $params = []): RouteResultInterface
    {
        $result = new self();
        $result->success = true;
        $result->route = $route;
        $result->params = $params;

        return $result;
    }

    /**
     * @param array|null $methods
     * @return RouteResultInterface
     */
    public static function fromRouteFailure(?array $methods): RouteResultInterface
    {
        $result = new self();
        $result->success = false;
        $result->methods = $methods ?: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];

        return $result;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return bool|Route
     */
    public function getMatchedRoute()
    {
        return $this->route ?: false;
    }

    /**
     * @return false|string
     */
    public function getMatchedRouteName()
    {
        if ($this->success && $this->route) {
            return $this->route->getName() ?: false;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getMatchedParams() : array
    {
        return $this->params;
    }

    public function isFailure() : bool
    {
        return !$this->success;
    }

    /**
     * @return bool
     */
    public function isMethodFailure() : bool
    {
        if (is_array($this->methods)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->methods ?: [];
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->success) {
            return $this->route->getMiddleware()->process($request, $handler);
        }

        return $handler->handle($request);
    }
}
