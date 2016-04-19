<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;
use Ionut\Sylar\Reactions\PsrLogger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Reactor
{
    /**
     * @var Filters
     */
    protected $filters;

    /**
     * @var array
     */
    protected $reactions;

    /**
     * @param Filters $filters
     * @param array   $reactions
     */
    public function __construct(Filters $filters, array $reactions = [])
    {
        $this->filters = $filters;
        $this->reactions = $reactions;
    }

    /**
     * Build an instance of the Handler by using the most common defaults.
     *
     * @param  LoggerInterface  $logger
     * @return static
     */
    static public function factory(LoggerInterface $logger, $threshold = 0)
    {
        return new static(
            new Filters([
                new \Ionut\Sylar\Filters\PHPIDS\Filter
            ]),
            [
                new PsrLogger($logger, $threshold)
            ]
        );
    }

    /**
     * Check a given request against the defined filters.
     *
     * @param ServerRequestInterface $request
     */
    public function digest(ServerRequestInterface $request)
    {
        $parameters = $this->getVerifiableParameters($request);

        array_walk_recursive($parameters, function ($value) use($request) {
            foreach ($this->filters->matches($value) as $filterReport) {
                $this->broadcast($request, $filterReport);
            }
        });
    }

    /**
     * @param ServerRequestInterface $request
     * @param FilterReportInterface  $filterReport
     */
    public function broadcast(ServerRequestInterface $request, FilterReportInterface $filterReport)
    {
        $report = new Report($request, $filterReport);

        foreach ($this->reactions as $reaction) {
            if ($reaction->shouldReact($report)) {
                $reaction->reactTo($report);
            }
        }
    }

    /**
     * Get the values that should be checked for security intrusions.
     *
     * @param  ServerRequestInterface  $request
     * @return array
     */
    protected function getVerifiableParameters(ServerRequestInterface $request)
    {
        return [$request->getServerParams(), $request->getBody()->__toString()];
    }
}