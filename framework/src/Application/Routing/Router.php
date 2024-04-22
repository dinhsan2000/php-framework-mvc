<?php

namespace Application\Routing;

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Route;
use Phroute\Phroute\RouteCollector;
use ReflectionClass;
use ReflectionMethod;
class Router
{
    /**
     * The RouteCollector instance
     *
     * @var RouteCollector
     */
    protected static RouteCollector $routes;

    /**
     * The Dispatcher instance
     *
     * @var Dispatcher|null
     */
    protected static ?Dispatcher $dispatcher = null;

    /**
     * Get the instance of the Router
     *
     * @return RouteCollector
     */
    protected static function getRoutes(): RouteCollector
    {
        if (!isset(self::$routes)) {
            self::$routes = new RouteCollector();
        }
        return self::$routes;
    }

    /**
     * Get the instance of the Dispatcher
     *
     * @return Dispatcher
     */
    protected static function getDispatcher(): Dispatcher
    {
        if (!isset(self::$dispatcher)) {
            self::$dispatcher = new Dispatcher(self::getRoutes()->getData());
        }
        return self::$dispatcher;
    }

    /**
     * Handle all registered routes
     *
     * @return mixed
     */
    public static function handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        return self::getDispatcher()->dispatch($method, $uri);
    }

    /**
     * Register a new GET route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function get(string $uri, array|string|null $action, $filter = []): RouteCollector
    {
        $cass = $action[0];
        return self::getRoutes()->addRoute('GET',$uri, [$action[0], $action[1]], $filter);
    }

    /**
     * Register a new POST route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function post(string $uri, array|string|null $action): RouteCollector
    {
        return self::getRoutes()->addRoute('POST', $uri, [$action[0], $action[1]]);
    }

    /**
     * Register a new PUT route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function put(string $uri, array|string|null $action): RouteCollector
    {
        return self::getRoutes()->addRoute('PUT', $uri, [$action[0], $action[1]]);
    }

    /**
     * Register a new PATCH route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function patch(string $uri, array|string|null $action): RouteCollector
    {
        return self::getRoutes()->addRoute('PATCH', $uri, [$action[0], $action[1]]);
    }

    /**
     * Register a new DELETE route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function delete(string $uri, array|string|null $action): RouteCollector
    {
        return self::getRoutes()->addRoute('DELETE', $uri, [$action[0], $action[1]]);
    }

    /**
     * Register a new OPTIONS route with the router
     *
     * @param string $uri
     * @param array|string|null $action
     * @return RouteCollector
     */
    public static function options(string $uri, array|string|null $action): RouteCollector
    {
        return self::getRoutes()->addRoute('OPTIONS', $uri, [$action[0], $action[1]]);
    }

    /**
     * Handle dynamic, static calls to the object
     *
     * @param string $name
     * @param array $arguments
     *
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return (new static)->$name(...$arguments);
    }
}