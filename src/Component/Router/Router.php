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
    
    public function __construct(Request $request) 
    {
        $this->routes = [];
        $this->request = $request;
    }

    
    public function setRoutes(string $routeConfigFile) 
    {
        if ((!$this->existsConfigFile($routeConfigFile)))
            throw new FileNotFoundException (sprintf('File: %s not found.',$routeConfigFile));
        
        $routes = include $routeConfigFile;
        
        if (!is_array($routes))
            throw new UnexpectedContentException (sprintf ('Routerconfig musst be a array'));
        
        $this->routes = $routes;
    }

    
    public function match()
    {        
        $requestURI = $this->getModifiedRequestURI();        
        
        foreach ($this->routes as $route => $container) 
        {                        
            $matches = [];
            $regEx = $this->getRegEx($container['method'], $container['path']);
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
    
    protected function getModifiedRequestURI() : string
    {
        return $this->request->getMethod().'_'.$this->request->getRequestUri();
    }


    protected function existsConfigFile(string $configFile) : bool
    {
        if ((!is_file($configFile))  || (!is_readable($configFile)))
            return false;
        return true;
    }


    protected function getRegEx(string $method, string $route) : string
    {
        $regEx = '('.$method.')_'.$route;
        $regEx = "~^$regEx/?$~i";
        return $regEx;
    }    
}
