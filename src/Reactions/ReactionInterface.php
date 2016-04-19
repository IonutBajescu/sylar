<?php

namespace Ionut\Sylar\Reactions;


use Ionut\Sylar\Report;

interface ReactionInterface
{

    /**
     * @param  Report  $report
     * @return bool
     */
    public function shouldReact(Report $report);

    /**
     * @param Report $report
     */
    public function reactTo(Report $report);
}