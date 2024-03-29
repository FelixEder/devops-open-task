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

    /** @var int */
    public $pull_requests;

    public function __construct(array $repo)
    {
        $this->full_name = $repo['full_name'];
        $this->stars = $repo['stars'];
        $this->forks = $repo['forks'];
        $this->issues = $repo['issues'];
        $this->commits = $repo['commits'];
<<<<<<< HEAD
        $this->full_name = $repo['full_name'];
=======
        $this->pull_requests = $repo['pull_requests'];
>>>>>>> 06924c1f71a8fa3a94de9b2ca115ff1f3f50a32b
    }
}
