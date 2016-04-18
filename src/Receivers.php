<?php

namespace Ionut\Sylar;


class Receivers
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Broadcast a given report to the receivers.
     *
     * @param Report $report
     */
    public function broadcast(Report $report)
    {
        foreach ($this->items as $receiver) {
            $receiver->receive($report);
        }
    }
}