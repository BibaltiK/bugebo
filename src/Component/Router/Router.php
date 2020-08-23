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
        $this->routes[] = $route;
    }
}
