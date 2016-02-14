<?php

namespace Ray\Di;

use Ray\Compiler\DiCompiler;
use Ray\Di\Exception\Unbound;
use Ray\Di\Exception\Untargetted;

class AssistedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InjectorInterface
     */
    private $injector;

    public function setup()
    {
        $this->injector = new Injector(new FakeToBindModule(new AssistedModule));
    }

    public function tearDown()
    {
        parent::tearDown();
        foreach (new \RecursiveDirectoryIterator($_ENV['TMP_DIR'], \FilesystemIterator::SKIP_DOTS) as $file) {
            unlink($file);
        }
    }

    public function testAssisted()
    {
        $consumer = $this->injector->getInstance(FakeAssistedConsumer::class);
        /* @var $consumer FakeAssistedConsumer */
        $assistedDependency = $consumer->assistOne('a', 'b');
        $expecetd = FakeRobot::class;
        $this->assertInstanceOf($expecetd, $assistedDependency);
    }

    public function testAssistedWithName()
    {
        $this->injector = new Injector(new FakeInstanceBindModule(new AssistedModule));
        $consumer = $this->injector->getInstance(FakeAssistedConsumer::class);
        /* @var $consumer FakeAssistedConsumer */
        $assistedDependency = $consumer->assistWithName('a7');
        $expecetd = 1;
        $this->assertSame($expecetd, $assistedDependency);
    }
}