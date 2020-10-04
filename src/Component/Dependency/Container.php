<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Dependency;
use Psr\Container\ContainerInterface;
use Exdrals\Excidia\Component\Exception\NotFoundException;


class Container implements ContainerInterface
{
    protected array $dependencies;

    protected array $objects;

    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public function set(string $class, object $instance): void
    {
        $this->objects[$class] = $instance;
    }

    public function get($class): object
    {
        if (array_key_exists($class, $this->objects))
        {
            return $this->objects[$class];
        }

        if (!$this->has($class))
        {
            throw new NotFoundException(sprintf('Dependency %s does not exist',$class));
        }

        $params = array_map([$this, 'get'], $this->dependencies[$class]);

        $this->objects[$class] = new $class(...$params);

        return $this->objects[$class];
    }

    public function has($dependency): bool
    {
        return (boolean)array_key_exists($dependency, $this->dependencies);
    }
}