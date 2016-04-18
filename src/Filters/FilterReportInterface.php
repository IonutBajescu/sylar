<?php

namespace Ionut\Sylar\Filters;


interface FilterReportInterface
{
    public function __toString();

    /**
     * @return mixed
     */
    public function getImpact();
}