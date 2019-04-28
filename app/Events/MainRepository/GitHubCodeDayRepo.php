<?php

namespace App\Events\MainRepository;

use App\Events\DashboardEvent;

class GitHubCodeDayRepo extends DashboardEvent
{
    /** @var int */
    public $forks;

    /** @var int */
    public $commits;

    /** @var int */
    public $issues;

    /** @var int */
    public $stars;

    public function __construct(array $totals)
    {
        foreach ($totals as $statisticName => $total) {
            $this->$statisticName = $total;
        }
    }
}
