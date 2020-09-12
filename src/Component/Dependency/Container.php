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
        
        $dependencies = parse_ini_file($configFile, true, INI_SCANNER_TYPED);
        
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
            return $this->add($class);
        }
        $params = [];
        foreach ($this->dependencies[$class] as $dependencies => $dependency)
        {
            $params[] = $this->get($dependency);
        }        
        
        $object = new $class(...$params);
        return $this->addObject($class, $object);
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
