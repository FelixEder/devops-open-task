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
    }

    public function fetchRepo(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('repo', 'show', [$userName, $repoName]));
    }

    public function fetchRepoCommits(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('repos', 'commits', [$userName, $repoName]));
    }

    public function fetchMainRepoStats(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('repo', 'show', [$userName, $repoName]));
    }

    public function fetchPublicRepositories(string $userName): Collection
    {
        $repos = $this->fetchAllResults('user', 'repositories', [$userName]);

        return collect($repos)->filter(function ($repo) {
            return $repo['private'] === false;
        });
    }

    public function fetchContributors(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('repo', 'statistics', [$userName, $repoName]));
    }

    public function fetchPullRequests(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('pull_request', 'all', [$userName, $repoName]));
    }

    public function fetchEvents(string $userName, string $repoName): Collection
    {
        return collect($this->fetchAllResults('repo', 'events', [$userName, $repoName]));
    }

    protected function fetchAllCommitResults(string $interfaceName, string $method, array $parameters)
    {
        return (new ResultPager($this->client))->fetchAll(
            $this->client->api($interfaceName)->commits(),
            $method,
            $parameters
        );
    }

    protected function fetchAllResults(string $interfaceName, string $method, array $parameters)
    {
        return (new ResultPager($this->client))->fetchAll(
            $this->client->api($interfaceName),
            $method,
            $parameters
        );
    }
}
