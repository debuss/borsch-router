<?php
/**
 * @author debuss-a
 */

namespace Borsch\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Trait HttpMethodTrait
 */
trait HttpMethodTrait
{

    /**
     * @param string $path
     * @param MiddlewareInterface|callable $middleware
     * @param string|null $name
     */
    public function get(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function post(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function put(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function delete(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function patch(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function head(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }

    /**
     * @param string $path
     * @param MiddlewareInterface|callable$middleware
     * @param string|null $name
     */
    public function options(string $path, $middleware, ?string $name): void
    {
        $this->addRoute(new Route($path, $middleware, [strtoupper(__FUNCTION__)], $name));
    }
}