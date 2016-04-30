<?php

namespace Ionut\Sylar;


class NormalizedValue
{
    /**
     * The original parameter value and the provenience of all the variants.
     *
     * @var string
     */
    protected $original;

    /**
     * Variants produced by each filter.
     *
     * @var NormalizedValueVariant[]
     */
    public $variants;

    /**
     * @param string $original
     * @param array  $variants
     */
    public function __construct($original, array $variants = [])
    {
        $this->original = $original;
        $this->variants = $variants;
    }

    public function getVariantsWithOriginal()
    {
        return array_merge(
            [new NormalizedValueVariant($this->original)],
            $this->variants
        );
    }

    /**
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }
}