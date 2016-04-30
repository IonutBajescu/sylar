<?php

namespace Ionut\Sylar;


use Ionut\Sylar\Filters\FilterReportInterface;
use Ionut\Sylar\Normalizers\NormalizerInterface;
use Ionut\Sylar\Normalizers\PHPIDSConverter;
use Ionut\Sylar\Reactions\PsrLogger;
use Ionut\Sylar\Reactions\ReactionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Reactor
{
    /**
     * @var Filters
     */
    protected $filters;

    /**
     * @var ReactionInterface[]
     */
    protected $reactions;

    /**
     * @var NormalizerInterface[]
     */
    protected $normalizers;

    /**
     * @param  Filters                $filters
     * @param  ReactionInterface[]    $reactions
     * @param  NormalizerInterface[]  $normalizers
     */
    public function __construct(Filters $filters, array $reactions = [], array $normalizers)
    {
        $this->filters = $filters;
        $this->reactions = $reactions;
        $this->normalizers = $normalizers;
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
            ],
            [
                new PHPIDSConverter()
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
        $parameters = $this->normalize($this->getVerifiableParameters($request));

        array_walk_recursive($parameters, function (NormalizedValue $value) use($request) {
            if ($filterReports = $this->filters->matches($value)) {
                $this->broadcast(new Report(iterator_to_array($filterReports), $request));
            }
        });
    }

    /**
     * @param   array  $parameters
     * @return  array
     */
    public function normalize(array $parameters)
    {
        foreach ($this->normalizers as $normalizer) {
            $parameters = $normalizer->normalize($parameters);
        }

        return $parameters;
    }

    /**
     * @param Report $report
     */
    public function broadcast(Report $report)
    {
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