<?php

namespace Ionut\Sylar\Filters\PHPIDS;


use Ionut\Sylar\Filters\FilterInterface;

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
     * @param  string $value
     * @return mixed
     */
    public function matches($value)
    {
        foreach ($this->filters as $filter) {
            if ($this->checkAgainstRule($filter->rule, $value)) {
                return new FilterReport($filter, $value);
            }
        }
    }

    /**
     * @param  string  $rule
     * @param  string  $value
     * @return boolean
     */
    protected function checkAgainstRule($rule, $value)
    {
        return preg_match('/'.$rule.'/', $value);
    }
}