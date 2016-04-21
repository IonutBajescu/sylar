<?php


namespace Ionut\Sylar\Reactions\Traits;


use Ionut\Sylar\Report;

trait ReactBasedOnThreshold
{
    /**
     * @var int
     */
    protected $threshold = 0;

    public function shouldReact(Report $report)
    {
        return $report->getTotalImpact() > $this->threshold;
    }
}