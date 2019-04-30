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
                $filtered = $repo->only([
                    'full_name',
                    'forks_count',
                    'stargazers_count',
                    'open_issues_count'
                ]);

                $commitsCount = $gitHub
                    ->fetchRepoCommits($userName, $repoName)
                    ->count();

                $combined = $filtered->put('commits_count', $commitsCount);

                return $combined;
            });

        event(new GitHubRepoFetched($repo->toArray()));

        $this->info('Repo loaded!');
    }
}
