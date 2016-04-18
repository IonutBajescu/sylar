<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Receivers\PsrLogger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Handler
{
    /**
     * @var Filters
     */
    protected $filters;

    /**
     * @var Receivers
     */
    protected $receivers;

    public function __construct(Filters $filters, Receivers $receivers)
    {
        $this->filters = $filters;
        $this->receivers = $receivers;
    }

    static public function factory(LoggerInterface $logger)
    {
        return new static(
            new Filters([
                new \Ionut\Sylar\Filters\PHPIDS\Filter
            ]),
            new Receivers([
                new PsrLogger($logger)
            ])
        );
    }
    
    public function digest(ServerRequestInterface $request)
    {
        $parameters = $this->getVerifiableParameters($request);

        array_walk_recursive($parameters, function ($value) use($request) {
            $this->checkAgainstFilters($value, $request);
        });
    }

    protected function getVerifiableParameters(ServerRequestInterface $request)
    {
        return [$request->getServerParams(), $request->getBody()->__toString()];
    }

    protected function checkAgainstFilters($value, ServerRequestInterface $request)
    {
        foreach ($this->filters as $filter) {
            if ($filterReport = $filter->matches($value)) {
                $this->receivers->broadcast(
                    new Report($request, $filterReport)
                );
            }
        }
    }

}