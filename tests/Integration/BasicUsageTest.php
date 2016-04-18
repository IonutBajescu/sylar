<?php

namespace Ionut\Sylar\Tests\Integration;


use Ionut\Sylar\Handler;
use Monolog\Logger;
use Zend\Diactoros\ServerRequest;

class BasicUsageTest extends TestCase
{
    public function testBasicBootstrapping()
    {
        $handler = Handler::factory(new Logger('testing'));
        $handler->digest(new ServerRequest());
    }
}