<?php

namespace App\Console\Components\Repository;

use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;
use App\Events\Repository\GitHubRepoFetched;

class FetchGitHubRepoForks extends Command
{
    protected $signature = 'dashboard:fetch-github-repo-forks';

    protected $description = 'Fetch GitHub repository forks';

    public function handle(GitHubApi $gitHub)
    {
        $this->info('Fetching GitHub repo repository forks');

        $userName = config('services.github.username');
        $repoName = config('services.github.repo');

        $repo = $gitHub
            ->fetchRepoForks($userName, $repoName)
            ->pipe(function (Collection $repos) use (
                $gitHub, $userName, $repoName
            ) {
                return $repos->map(function ($repo) {
                    return [
                        ''
                    ];
                });
                $filtered = $repo->only([
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
