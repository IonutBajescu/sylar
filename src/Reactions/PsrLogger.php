<?php

namespace Ionut\Sylar\Reactions;


use Ionut\Sylar\Report;
use Psr\Log\LoggerInterface;

class PsrLogger implements ReactionInterface
{
    use Traits\ReactBasedOnThreshold;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger, $threshold = 0)
    {
        $this->logger = $logger;
        $this->threshold = $threshold;
    }

    public function reactTo(Report $report)
    {
        $this->logger->emergency($report);
    }
}