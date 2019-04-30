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
        $this->stars = $repo['stargazers_count'];
        $this->forks = $repo['forks_count'];
        $this->issues = $repo['open_issues_count'];
        $this->commits = $repo['commits_count'];
    }
}
