<?php

namespace App\Events\Repository;

use App\Events\DashboardEvent;

class GitHubRepoFetched extends DashboardEvent
{
    /** @var int */
    public $forks;

    /** @var int */
    public $commits;

    /** @var int */
    public $issues;

    /** @var int */
    public $stars;

    public function __construct(array $repo)
    {
        $this->stars = $repo['stars'];
        $this->forks = $repo['forks'];
        $this->issues = $repo['issues'];
        $this->commits = $repo['commits'];
    }
}
