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

    public function __construct(ServerRequestInterface $request, FilterReportInterface $filterReport)
    {
        $this->request = $request;
        $this->filterReport = $filterReport;
    }

    public function format()
    {
        $datetime = (new \DateTime())->format(\DateTime::ISO8601);
        return <<<REPORT
[$datetime] {$this->request->getUri()}

{$this->filterReport->format()}
REPORT;

    }
}