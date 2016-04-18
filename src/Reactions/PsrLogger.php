<?php

namespace Ionut\Sylar\Receivers;


use Ionut\Sylar\Report;
use Psr\Log\LoggerInterface;

class PsrLogger
{
    use ReactBasedOnTreshold;

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
        $this->logger->emergency($report);
    }
}