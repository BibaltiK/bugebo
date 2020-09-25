<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Dependency;
use Psr\Container\ContainerInterface;


class Container implements ContainerInterface
{
    protected array $dependencies;

    protected array $objects;

    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;

        $this->objects[self::class] = $this;
    }

    public function set(string $class, object $instance)
    {
        $this->objects[$class] = $instance;
    }

    public function get($class)
    {
        if (isset($this->objects[$class]))
        {
            return $this->objects[$class];
        }


        if (!isset($this->dependencies[$class]))
        {
            var_dump($this->dependencies);
            var_dump($class);die();
            throw new Exception('Dependency ' . $class . ' does not exist');
        }

        $dependency = $this->dependencies[$class];

        if (!class_exists($class)) {
            return $dependency;
        }

        $params = array_map([$this, 'get'], $this->dependencies[$class]);

        $this->objects[$class] = new $class(...$params);

        return $this->objects[$class];
    }

    public function has($dependency)
    {
        return true;
    }
}