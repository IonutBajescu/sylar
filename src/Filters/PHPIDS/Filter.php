<?php

namespace Ionut\Sylar\Filters\PHPIDS;

use Ionut\Sylar\Filters\FilterInterface;
use Ionut\Sylar\Filters\FilterReportInterface;
use Ionut\Sylar\NormalizedValueVariant;

class Filter implements FilterInterface
{

    /**
     * @var array
     */
    protected $filters;

    public function __construct()
    {
        $contents = json_decode(file_get_contents(__DIR__.'/_filters.json'));
        $this->filters = $contents->filters->filter;
    }

    /**
     * Check a given value against this set of filters.
     *
     * @param NormalizedValueVariant|string $value
     * @return FilterReportInterface|null
     */
    public function matches(NormalizedValueVariant $value)
    {
        foreach ($this->filters as $filter) {
            if ($this->checkAgainstRule($filter->rule, $value->getValue())) {
                return new Report($filter, $value);
            }
        }
    }

    /**
     * @param  string $rule
     * @param  string $value
     * @return boolean
     */
    protected function checkAgainstRule($rule, $value)
    {
        return preg_match('/'.$rule.'/', $value);
    }
}