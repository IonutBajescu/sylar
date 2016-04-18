<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;
use Psr\Http\Message\ServerRequestInterface;

class Report
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var FilterReportInterface
     */
    protected $filterReport;

    /**
     * @param ServerRequestInterface $request
     * @param FilterReportInterface  $filterReport
     */
    public function __construct(ServerRequestInterface $request, FilterReportInterface $filterReport)
    {
        $this->request = $request;
        $this->filterReport = $filterReport;
    }

    /**
     * Export the report to a human-readable string.
     *
     * @return string
     */
    public function __toString()
    {
        $datetime = (new \DateTime())->format(\DateTime::ISO8601);

        return "[$datetime] {$this->request->getUri()}\n\n{$this->filterReport}";
    }

    /**
     * @return FilterReportInterface
     */
    public function getFilterReport()
    {
        return $this->filterReport;
    }
}