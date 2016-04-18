<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;

class Receivers
{
    /**
     * @var array
     */
    protected $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function broadcast(Report $report)
    {
        foreach ($this->items as $receiver) {
            $receiver->receive($report);
        }
    }
}