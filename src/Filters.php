<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;

class Filters
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param  string  $value
     * @return Filters\FilterReportInterface[]
     */
    public function matches($value)
    {
        foreach ($this->items as $item) {
            if ($filterReport = $item->matches($value)) {
                yield $filterReport;
            }
        }
    }
}