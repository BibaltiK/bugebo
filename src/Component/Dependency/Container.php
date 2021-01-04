<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Dependency;
use Psr\Container\ContainerInterface;
use Exdrals\Bugebo\Component\Exception\NotFoundException;
use function array_key_exists;
use function array_map;


class Container implements ContainerInterface
{
    protected array $objects = [];

    public function __construct(protected array $dependencies = [])
    {}

    public function set(string $class, object $instance): void
    {
        $this->objects[$class] = $instance;
    }

    public function get($id): object
    {
        if (array_key_exists($id, $this->objects)) {
            return $this->objects[$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException(sprintf('Dependency %s does not exist', $id));
        }

        $params = array_map([$this, 'get'], $this->dependencies[$id]);

        return $this->objects[$id] = new $id(...$params);
    }

    public function has($id): bool
    {
        return (boolean)array_key_exists($id, $this->dependencies);
    }
}