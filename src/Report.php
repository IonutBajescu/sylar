<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Sums all the FilterReports for the current request.
 */
class Report
{

    /**
     * @var FilterReportInterface[]
     */
    protected $filterReports;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @param  FilterReportInterface[]  $filterReports
     * @param  ServerRequestInterface   $request
     */
    public function __construct(array $filterReports, ServerRequestInterface $request)
    {
        $this->filterReports = $filterReports;
        $this->request = $request;
    }

    /**
     * Calculate the total impact of the contained filter reports.
     *
     * @return int
     */
    public function getTotalImpact()
    {
        return array_reduce($this->filterReports, function($carry, FilterReportInterface $filterReport) {
            return $carry + $filterReport->getImpact();
        });
    }

    /**
     * Export the report to a human-readable string.
     *
     * @return string
     */
    public function __toString()
    {
        $datetime = (new \DateTime())->format(\DateTime::ISO8601);

        $filterReports = implode("\n\n", $this->filterReports);
        return "[$datetime] {$this->request->getUri()}\n\n{$filterReports}";
    }
}