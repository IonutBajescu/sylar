<?php

namespace Ionut\Sylar\Receivers;


use Psr\Log\LoggerInterface;

class PsrLogger
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function receive(Report $report)
    {
        
    }
}