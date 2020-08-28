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

    
    public function __construct() 
    {
        $this->routes = [];
    }

    
    public function setRoutes(string $routeConfigFile) 
    {
        if ((!is_file($routeConfigFile))  || (!is_readable($routeConfigFile)))
            throw new FileNotFoundException (sprintf('File: %s not found.',$routeConfigFile));
        
        $routes = include $routeConfigFile;
        
        if (!is_array($routes))
            throw new UnexpectedContentException (sprintf ('Routerconfig musst be a array'));
        
        $this->routes = $routes;
    }

    
    public function match(Request $request)
    {        
        $requestURI = $request->getMethod().'_'.$request->getRequestUri();        
        
        foreach ($this->routes as $route => $container) 
        {                        
            $matches = [];
            $regEx = $this->getRegEx($container['method'], $route);
            if (!preg_match($regEx, $requestURI, $matches)) 
            {
                continue;
            }                        
            if (array_key_exists('params', $container))
                    $container['params'] = $matches[array_key_last($matches)];
            
            return $container;
        }    
          
        throw new RouteNotFoundException(sprintf('Keine entsprechende Route für <b>%s</b> gefunden.',$requestURI));
    }
    
    protected function getRegEx(string $method, string $route) : string
    {
        $regEx = '('.$method.')_'.$route;
        $regEx = "~^$regEx/?$~i";
        return $regEx;
    }
}
