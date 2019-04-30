<?php

namespace App\Console\Components\Repository;

use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;
use App\Events\Repository\GitHubRepoFetched;

class FetchGitHubRepo extends Command
{
    protected $signature = 'dashboard:fetch-github-repo';

    protected $description = 'Fetch GitHub repository';

    public function handle(GitHubApi $gitHub)
    {
        $this->info('Fetching GitHub repo repository');

        $userName = config('services.github.username');
        $repoName = config('services.github.repo');

        $repo = $gitHub
            ->fetchRepo($userName, $repoName)
            ->pipe(function (Collection $repo) use (
                $gitHub, $userName, $repoName
            ) {
                return [
                    'full_name' => $repo->get('full_name'),
                    'stars'   => $repo->get('stargazers_count'),
                    'issues'  => $repo->get('open_issues_count'),
                    'forks'   => $repo->get('forks_count'),
                    'commits' => $gitHub->fetchRepoCommits($userName, $repoName)->count()
                ];
            });

        event(new GitHubRepoFetched($repo));

        $this->info('Repo loaded!');
    }
}
