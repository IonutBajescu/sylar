<?php

namespace Ionut\Sylar\Tests\Unit\Filters;


use Ionut\Sylar\Filters\FilterReportInterface;
use Ionut\Sylar\Filters\PHPIDS\Filter;
use Ionut\Sylar\Tests\TestCase;

class PHPIDSTest extends TestCase
{
    public function testMatchesWithRealDataReturnsReportWhenGivenSQLInjection()
    {
        $filter = new Filter();
        $this->assertInstanceOf(
            FilterReportInterface::class,
            $filter->matches('1 UNION SELECT 1,null,null--')
        );
    }
}