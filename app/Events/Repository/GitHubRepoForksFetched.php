<?php

namespace App\Events\Repository;

use App\Events\DashboardEvent;

class GitHubRepoForksFetched extends DashboardEvent
{
    /** @var int */
    public $forks;

    public function __construct(array $forks)
    {
        $this->forks = $forks;
    }
}
