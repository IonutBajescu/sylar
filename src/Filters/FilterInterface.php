<?php

namespace Ionut\Sylar\Filters;


use Ionut\Sylar\NormalizedValueVariant;

interface FilterInterface
{
    /**
     * Check a given value against this set of filters.
     *
     * @param  NormalizedValueVariant $value
     * @return FilterReportInterface|null
     */
    public function matches(NormalizedValueVariant $value);
}