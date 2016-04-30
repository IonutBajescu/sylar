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
     * @param  NormalizedValue  $normalizedValue
     * @return Filters\FilterReportInterface[]
     */
    public function matches(NormalizedValue $normalizedValue)
    {
        foreach ($this->items as $item) {
            foreach ($normalizedValue->getVariantsWithOriginal() as $variant) {
                if ($filterReport = $item->matches($variant)) {
                    yield $filterReport;
                    break;
                }
            }
        }
    }
}