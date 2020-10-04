<?php

namespace Component\Dependency;

use Exdrals\Excidia\Component\Dependency\Container;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;

class DependencyContainerTest extends TestCase
{
    public function testArrayKeyExists()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $expectedObject = new Request();
        $object = $container->get(Request::class);
        $this->assertEquals($expectedObject,$object);
    }

    public function testCanSetDependency()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $testClass = new Request();
        $container->set(Request::class,$testClass);
        $object = $container->get(Request::class);
        $this->assertEquals($testClass,$object);
    }

    public function testHasReturnTrue()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $this->assertTrue($container->has(Request::class));
    }

    public function testHasReturnFalse()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $this->assertFalse($container->has('Request-Fail::class'));
    }
}
