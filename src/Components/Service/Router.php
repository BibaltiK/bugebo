<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Components\Service;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouteCollection;

class Router {
    
    protected string $configPath;
    
    protected string $configFile;
    
    protected Request $request;
    
    protected RouteCollection $routeCollection;
    
    protected string $routeClass;
    
    protected string $routeAction;
    
    protected ?array $routeParam;


    public function __construct(Request $request,
                                string $configPath = __DIR__.'/../../../config', 
                                string $configFile = 'routes.yaml'
                               )
    {
        $this->configPath = $configPath;
        $this->configFile = $configFile; 
        $this->request = $request;
    }
    
    public function load() : self
    {
        $fileLocator = new FileLocator(array($this->configPath));
        $loader = new YamlFileLoader($fileLocator);
        $this->routeCollection = $loader->load($this->configFile);           
        return $this;
    }
    
    public function matchRequest() : self
    {
        $matcher = new UrlMatcher($this->routeCollection, (new RequestContext())->fromRequest($this->request));            
        $parameters = $matcher->matchRequest($this->request);
        $matchClassAndAction = explode('::', $parameters['_controller']);
        $this->routeClass = $matchClassAndAction[0];
        $this->routeAction = $matchClassAndAction[1];        
        unset($parameters['_controller'], $parameters['_route']);
        $this->routeParam = $parameters;
        return $this;
    }
    
    public function callRoute() : Response
    {
        if (!class_exists($this->routeClass))
            throw new ResourceNotFoundException(
                            sprintf ('Class %s not found.', $this->routeClass)
                    );
        if (!method_exists($this->routeClass, $this->routeAction))
            throw new ResourceNotFoundException(sprintf ('Method %s not exists in Class %s.', $this->routeAction, $this->routeClass));
        return call_user_func_array(array(new $this->routeClass(),$this->routeAction), $this->routeParam);
    }
    
}
