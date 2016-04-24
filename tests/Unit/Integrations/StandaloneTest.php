<?php

namespace Ionut\Sylar\Tests\Unit\Integrations;


use Ionut\Sylar\Integrations\Standalone;
use Ionut\Sylar\Reactor;
use Ionut\Sylar\Tests\TestCase;

class StandaloneTest extends TestCase
{
    public function testShouldCreateReactorSuccessfully()
    {
        $standalone = new Standalone(tempnam('/tmp', 'tmpfile'));
        $this->assertInstanceOf(
            Reactor::class,
            $standalone->getReactor()
        );
    }

    public function testShouldRunWithoutExceptions()
    {
        $standalone = new Standalone(tempnam('/tmp', 'tmpfile'));
        $standalone->run();
    }
}