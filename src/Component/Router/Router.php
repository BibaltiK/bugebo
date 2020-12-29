<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Router;

use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use Symfony\Component\HttpFoundation\Request;

class Router 
{
    protected ?array $routes = [];
    protected Request $request;
    protected string $requestURI;

    public function __construct(Request $request) 
    {
        $this->routes = [];
        $this->request = $request;
        $this->requestURI = $this->getModifiedRequestURI();
    }

    public function setRoutes(array $routeConfig) : void
    {
        $this->routes = $routeConfig;
    }

    public function match() : array
    {               
        foreach ($this->routes as $route => $routeInfo) 
        {                        
            $matches = [];
            $regEx = $this->getRegEx($routeInfo['method'], $routeInfo['path']);
            
            if (!preg_match($regEx, $this->requestURI, $matches)) 
            {
                continue;
            }                        
            
            if (array_key_exists('params', $routeInfo))
            {

                $methodParams = explode('/', rtrim($matches[array_key_last($matches)],'/'));
                if(count($routeInfo['params']) != count($methodParams))
                {
                    throw new RouteNotFoundException(sprintf('No matching route found for: <b>%s</b>',$this->requestURI));
                }
                $routeInfo['params'] = $methodParams;

            }
            return $routeInfo;
        }
        throw new RouteNotFoundException(sprintf('No matching route found for: <b>%s</b>',$this->requestURI));
    }
    
    protected function getModifiedRequestURI() : string
    {
        return $this->request->getMethod().'_'.$this->request->getRequestUri();
    }

    protected function getRegEx(string $method, string $route) : string
    {
        $regEx = '('.$method.')_'.$route;
        $regEx = "~^$regEx/?$~i";
        return $regEx;
    }    
}
