<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Dependency;

class Container 
{
    protected ?array $dependencies = [];
    
    protected ?array $objects = [];
    
    public function __construct(?string $configFile = null)
    {
        $this->dependencies = [];
        $this->objects = [];
        if ($configFile)
        {
            $this->readDependencyConfig($configFile);
        }
    }

    public function readDependencyConfig(string $configFile)
    {
        if (!$this->existsConfigFile($configFile))
            throw new FileNotFoundException (sprintf('File: %s not found.',$configFile));
        
        $dependencies = include $configFile;
        
        if (!is_array($dependencies))
            throw new UnexpectedContentException (sprintf('Dependency-Config must be array or null'));
        
        $this->dependencies = $dependencies;   
    }
    
    public function add(string $class) : object
    {
        $this->objects[$class] = new $class();
        return $this->objects[$class];
    }
    
    public function addObject(string $class, object $object) : object
    {
        $this->objects[$class] = $object;
        return $object;
    }
    
    public function get(string $class): ?object
    {        
        if (array_key_exists($class, $this->objects))
        {
            return $this->objects[$class];
        }
        if (!array_key_exists($class, $this->dependencies))
        {
            throw new Exception(sprintf('Klasse <b>%s</b> im Container nicht gefunden',$class));
        }
        $params = [];
        foreach ($this->dependencies[$class]['dependencies'] as $dependencies => $dependency)
        {
            $params[] = $this->get($dependency);
        }        
        
        $object = new $class(...$params);
        $this->addObject($class, $object);
        return $object;
    }

    protected function existsConfigFile(string $configFile) : bool
    {
        if ((!is_file($configFile))  || (!is_readable($configFile)))
        {
            return false;
        }            
        return true;
    }
}
