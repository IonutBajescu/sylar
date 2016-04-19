<?php

namespace Ionut\Sylar\Filters;


interface FilterReportInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return int
     */
    public function getImpact();
}