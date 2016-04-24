<?php

namespace Ionut\Sylar\Integrations;


use Ionut\Sylar\Reactor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\ServerRequestFactory;

class Standalone
{
    /**
     * @var Reactor
     */
    protected $reactor;

    /**
     * @param string $logFile
     */
    public function __construct($logFile)
    {
        $this->reactor = Reactor::factory($this->createLogger($logFile));
    }

    /**
     * Create a PSR-7 and send it to the reactor.
     */
    public function run()
    {
        $this->reactor->digest($this->createRequest());
    }

    /**
     * @return ServerRequestInterface
     */
    protected function createRequest()
    {
        return ServerRequestFactory::fromGlobals();
    }

    /**
     * @param string  $logFile
     * @return LoggerInterface
     */
    protected function createLogger($logFile)
    {
        $logger = new Logger('ids');
        $logger->pushHandler(new StreamHandler($logFile));
        return $logger;
    }

    /**
     * @return Reactor
     */
    public function getReactor()
    {
        return $this->reactor;
    }
}