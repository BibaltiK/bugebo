<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Router;
use Exdrals\Excidia\Interfaces\Comparable;

class RouteEntity implements Comparable {

    protected string $route;
    
    protected ?string $description;
    
    protected string $method;
    
    protected string $controller;
    
    protected string $action;
    
    protected ?array $params;

    public function __construct(string $route = '/',
                                ?string $description = null,
                                string $method = 'GET',
                                string $controller = '\\',
                                string $action = 'index',
                                array $params = []
                                ) 
    {
        $this->setRoute($route)
             ->setDescription($description)
             ->setMethod($method)
             ->setController($controller)
             ->setAction($action)
             ->setParams($params);
    }
    
    public function compare($compareRouteEntity): bool
    {
        return false;
    }
    public function getRoute(): string 
    {
        return $this->route;
    }

    public function getDescription(): ?string 
    {
        return $this->description;
    }

    public function getMethod(): string 
    {
        return $this->method;
    }

    public function getController(): string 
    {
        return $this->controller;
    }

    public function getAction(): string 
    {
        return $this->action;
    }
    
    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setMethod(string $method): self 
    {
        $this->method = $method;
        return $this;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }
    
    public function setParams(?array $params): self
    {
        $this->params = $params;
        return $this;
    }    
}
