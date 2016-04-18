<?php

namespace Ionut\Sylar\Tests\Unit;


use Ionut\Sylar\Filters;
use Ionut\Sylar\Tests\TestCase;

class FiltersTest extends TestCase
{
    public function testMatchesYieldsReport()
    {
        $filter = $this->getMock(Filters\FilterInterface::class);
        $filter
            ->expects($this->once())
            ->method('matches')
                ->with('testingValue')
                ->will($this->returnValue('somereport'));

        $filters = new Filters([$filter]);

        $this->assertEquals(
            ['somereport'],
            iterator_to_array($filters->matches('testingValue'))
        );
    }

    public function testMatchesYieldsNothingWhenFiltersReturnFalse()
    {
        $filter = $this->getMock(Filters\FilterInterface::class);
        $filter
            ->expects($this->once())
            ->method('matches')
            ->with('testingValue')
            ->will($this->returnValue(null));

        $filters = new Filters([
            $filter
        ]);

        $this->assertEquals(
            [],
            iterator_to_array($filters->matches('testingValue'))
        );
    }
}