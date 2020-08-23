<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Router;

use Exdrals\Excidia\Component\Router\RouteEntity;

class Router {
    
    protected array $routes = [];

    public function __construct() 
    {
        $this->routes = [];
    }
    
    public function add(RouteEntity $route): self
    {
        $this->routes[] = clone $route;
        
        return $this;
    }
    
    public function find(RouteEntity $routeToFind) : ?RouteEntity
    {
        foreach ($this->routes as $route)
        {
            if (($route->getRoute() === $routeToFind->getRoute()) && ($route->getMethod() === $routeToFind->getMethod()))
                return $route;
        }
        return null;
    }
}
