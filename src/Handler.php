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

    /**
     * @param Filters $filters
     * @param Receivers $receivers
     */
    public function __construct(Filters $filters, Receivers $receivers)
    {
        $this->filters = $filters;
        $this->receivers = $receivers;
    }

    /**
     * Build an instance of the Handler by using the most common defaults.
     *
     * @param  LoggerInterface  $logger
     * @return static
     */
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
                $this->receivers->broadcast(new Report($request, $filterReport));
            }
        });
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