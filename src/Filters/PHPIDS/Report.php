<?php

namespace Ionut\Sylar\Filters\PHPIDS;


use Ionut\Sylar\Filters\FilterReportInterface;

class Report implements FilterReportInterface
{
    /**
     * @var \stdClass
     */
    protected $rule;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param  \stdClass  $rule
     * @param  string     $value
     */
    public function __construct(\stdClass $rule, $value)
    {
        $this->rule  = $rule;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->formatRuleTags()} RULE{$this->rule->id} \"{$this->rule->description}\"";
    }
    
    /**
     * @return string
     */
    protected function formatRuleTags()
    {
        return strtoupper(implode(', ', $this->rule->tags->tag));
    }

    /**
     * @return int
     */
    public function getImpact()
    {
        return $this->rule->impact;
    }
}