<?php

namespace Ionut\Sylar\Filters;


interface FilterInterface
{
    /**
     * Check a given value against this set of filters.
     *
     * @param  string  $value
     * @return mixed
     */
    public function matches($value);
}