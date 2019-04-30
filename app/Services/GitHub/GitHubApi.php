<?php

namespace App\Services\GitHub;

use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

class GitHubApi
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->resultPager = new ResultPager($this->client);
    }

    public function fetchRepo(string $userName, string $repoName): Collection
    {
        return collect($this->resultPager
            ->fetchAll($this->client->api('repo'), 'show', [$userName, $repoName]));
    }

    public function fetchRepoCommits(string $userName, string $repoName): Collection
    {
        return collect($this->resultPager
            ->fetchAll($this->client
                ->api('repo')
                ->commits(), 'all', [$userName, $repoName, []]));
    }

    public function fetchRepoForks(string $userName, string $repoName): Collection
    {
        return collect($this->resultPager
            ->fetchAll($this->client
                ->api('repos')->forks(), 'all', [$userName, $repoName, []]));
    }
}
