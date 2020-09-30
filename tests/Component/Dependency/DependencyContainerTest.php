<?php

namespace Component\Dependency;

use Exdrals\Excidia\Component\Dependency\Container;
use PHPUnit\Framework\TestCase;

class DependencyContainerTest extends TestCase
{
    public function testArrayKeyExists()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $expectedObject = new \Symfony\Component\HttpFoundation\Request();
        $object = $container->get('Symfony\Component\HttpFoundation\Request');
        $this->assertEquals($expectedObject,$object);
    }

    public function testHasReturnTrue()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $this->assertTrue($container->has('Symfony\Component\HttpFoundation\Request'));
    }

    public function testHasReturnFalse()
    {
        $container = new Container(require __DIR__.'/../../../config/dependencies.php');
        $this->assertFalse($container->has('Symfony\Component\HttpFoundation\Request-Fail'));
    }
}
