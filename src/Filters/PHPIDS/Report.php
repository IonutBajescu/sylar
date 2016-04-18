<?php

namespace Ionut\Sylar\Filters\PHPIDS;


use Ionut\Sylar\Filters\FilterReportInterface;

class FilterReport implements FilterReportInterface
{
    /**
     * @var \stdClass
     */
    protected $filter;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param  \stdClass  $filter
     * @param  string     $value
     */
    public function __construct(\stdClass $filter, $value)
    {
        $this->filter = $filter;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function format()
    {
        return "{$this->formatRuleTags()} RULE{$this->filter->id} \"{$this->filter->description}\"";
    }

    /**
     * @return mixed
     */
    protected function formatRuleTags()
    {
        return strtoupper(implode(', ', $this->filter->tags->tag));
    }
}