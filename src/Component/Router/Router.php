<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Router;

use Exdrals\Bugebo\Component\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use function array_key_exists;
use function array_key_last;
use function count;
use function explode;
use function preg_match;
use function rtrim;

class Router
{
    protected array $routes = [];
    protected string $requestURI;

    public function __construct(protected Request $request)
    {
        $this->requestURI = $this->getModifiedRequestURI();
    }

    public function setRoutes(array $routeConfig): void
    {
        $this->routes = $routeConfig;
    }

    public function match(): array
    {
        $matches = [];
        foreach ($this->routes as $route => $routeInfo) {
            if(!$this->isRouteMatch($routeInfo, $matches)) {
                continue;
            }
            if(array_key_exists('params', $routeInfo)) {
                $methodParams = explode('/', rtrim($matches[array_key_last($matches)], '/'));
                if(count($routeInfo['params']) != count($methodParams)) {
                    throw new RouteNotFoundException(sprintf('No matching route found for: <b>%s</b>', $this->requestURI));
                }
                $routeInfo['params'] = $methodParams;
            }
            return $routeInfo;
        }
        throw new RouteNotFoundException(sprintf('No matching route found for: <b>%s</b>', $this->requestURI));
    }

    protected function isRouteMatch(array $route, array &$matches): bool
    {
        return (bool)preg_match(
                    $this->getRegEx($route['method'], $route['path']),
                    $this->requestURI,
                    $matches
                );
    }

    protected function getModifiedRequestURI(): string
    {
        return $this->request->getMethod() . '_' . $this->request->getRequestUri();
    }

    protected function getRegEx(string $method, string $route): string
    {
        return '~^(' . $method . ')_' . $route . '/?$~i';
    }
}
