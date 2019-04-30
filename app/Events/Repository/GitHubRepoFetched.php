<?php

namespace App\Events\Repository;

use App\Events\DashboardEvent;

class GitHubRepoFetched extends DashboardEvent
{
    /** @var string */
    public $full_name;

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
        $this->full_name = $repo['full_name'];
        $this->stars = $repo['stargazers_count'];
        $this->forks = $repo['forks_count'];
        $this->issues = $repo['open_issues_count'];
        $this->commits = $repo['commits_count'];
    }
}
