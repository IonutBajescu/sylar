<?php

namespace Ionut\Sylar\Tests\Integration;


use Ionut\Sylar\Handler;
use Ionut\Sylar\Tests\TestCase;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\ServerRequest;

class BasicUsageTest extends TestCase
{
    public function testBasicBootstrapping()
    {
        $logger = $this->getMock(LoggerInterface::class);
        $logger->expects($this->never())->method('emergency');

        $handler = Handler::factory($logger);
        $handler->digest(new ServerRequest());
    }

    public function testLogsIntoMonologWhenGivenCommonIntrusions()
    {
        
    }

    public function logsIntoMonologWhenGivenCommonIntrusionsProvider()
    {
        return [
            '1 UNION SELECT 1,null,null--',     // comment
            '1\'',                              // blind
        ];
    }
}