<?php

declare(strict_types=1);

namespace Castroitalo\Router;

use Castroitalo\Services\ServerService;
use InvalidArgumentException;
use PDO;

/**
 * Router
 *
 * @package Castroitalo\Router
 */
class Router
{
    /**
     * Available app methods
     */
    private const array AVAILABLE_METHODS = [
        'GET',
        'POST'
    ];

    /**
     * Initialize router components
     *
     * @param array $routes
     * @return void
     */
    public function __construct(
        private array $routes = []
    ) {}

    /**
     * Add a new route to the app
     *
     * @param string $method
     * @param string $route
     * @param array $controllerCallback
     * @param mixed ...$middlewaresCallback
     * @return void
     * @throws InvalidArgumentException
     */
    public function add(string $method, string $route, array $controllerCallback, array ...$middlewaresCallback): void
    {
        // Validate method
        if (!in_array($method, self::AVAILABLE_METHODS)) {
            throw new InvalidArgumentException('Method not allowed in route declaration.');
        }

        // Mounting middleware structure
        $middlewares = array_map(function (array $middleware) {
            return [
                'class'  => $middleware[0],
                'method' => $middleware[1]
            ];
        }, $middlewaresCallback);

        // Defining a new route
        $this->routes[$method][] = [
            'uri'      => $route,
            'controller' => [
                'class'  => $controllerCallback[0],
                'method' => $controllerCallback[1]
            ],
            'middlewares' => $middlewares
        ];
    }

    /**
     * Extract request URI parameters values if the URI is dynamic
     *
     * @param string $routePath Request URI
     * @param array $uriPatternMatches Request URI matches
     * @return array
     */
    private function extractUriParametersValues(string $routePath, array $uriPatternMatches): array
    {
        preg_match_all('/\{([^\}]+)\}/', $routePath, $paramNames);

        return array_combine($paramNames[1], $uriPatternMatches);
    }

    /**
     * Get request route
     *
     * @param string $requestMethod
     * @param string $requestRoute
     * @return null|array
     */
    private function getRequestedRoute(string $requestMethod, string $requestRoute): ?array
    {
        foreach ($this->routes[$requestMethod] as $route) {
            $routePatterns = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route['uri']);
            $routePatterns = "#^" . $routePatterns . "$#";

            if (preg_match($routePatterns, $requestRoute, $routePatternMatches)) {
                array_shift($routePatternMatches);

                $routeParameters = $this->extractUriParametersValues($route['uri'], $routePatternMatches);

                return [
                    'request_route'            => $route,
                    'request_route_parameters' => $routeParameters
                ];
            }
        }

        return null;
    }

    /**
     * Execute callbacks
     *
     * @param array $route
     * @return void
     */
    private function executeCallbacks(array $route): void
    {
        // Extract route info
        $callbackInfo = $route['request_route'];

        // Execute middlewares
        foreach ($route['request_route']['middlewares'] as $middleware) {
            $middlewareCallbackClass = $middleware['class'];
            $middlewareCallbackMethod = $middleware['method'];

            $middlewareInstance = new $middlewareCallbackClass();

            call_user_func([$middlewareInstance, $middlewareCallbackMethod]);
        }

        // Execute controller callback
        $controllerCallbackClass = $callbackInfo['controller']['class'];
        $controllerCallbackMethod = $callbackInfo['controller']['method'];
        $controllerCallbackParameters = $route['request_route_parameters'];

        $controllerInstance = new $controllerCallbackClass();

        call_user_func([$controllerInstance, $controllerCallbackMethod], $controllerCallbackParameters);
    }

    /**
     * Handle request
     *
     * @param string $method
     * @param string $route
     * @return void
     */
    public function handleRequest(string $method, string $route): void
    {
        $requestedRoute = $this->getRequestedRoute($method, $route);

        if (is_null($requestedRoute)) {
            ServerService::redirectTo(CONF_ROUTES_PAGE_NOT_FOUND);
            exit();
        }

        $this->executeCallbacks($requestedRoute);
    }

    /**
     * Get routes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
