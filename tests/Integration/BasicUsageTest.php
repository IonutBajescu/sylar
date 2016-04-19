<?php

namespace Ionut\Sylar\Tests\Integration;


use Ionut\Sylar\Reactor;
use Ionut\Sylar\Tests\TestCase;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\ServerRequest;

class BasicUsageTest extends TestCase
{
    public function testBasicBootstrapping()
    {
        $logger = $this->getMock(LoggerInterface::class);
        $logger->expects($this->never())->method('emergency');

        $handler = Reactor::factory($logger);
        $handler->digest(new ServerRequest());
    }

    /**
     * @dataProvider logsIntoMonologWhenGivenCommonIntrusionsProvider
     */
    public function testLogsIntoMonologWhenGivenCommonIntrusions($intrusion)
    {
        $logger = $this->getMock(LoggerInterface::class);
        $logger->expects($this->once())->method('emergency');

        $handler = Reactor::factory($logger);
        $handler->digest(new ServerRequest(compact('intrusion')));
    }

    public function logsIntoMonologWhenGivenCommonIntrusionsProvider()
    {
        return [
            ['1 UNION SELECT 1,null,null--'],
            ['<script></script>'],
            ['etc/passwd']
        ];
    }
}