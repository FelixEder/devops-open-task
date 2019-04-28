<?php

namespace App\Events\Statistics;

use App\Events\DashboardEvent;

class GitHubTotalsEvents extends DashboardEvent
{
    /** @var int */
    public $type;

    public function __construct(array $totals)
    {
        foreach ($totals as $statisticName => $total) {
            $this->$statisticName = $total;
        }
    }
}
