<?php

namespace App\Console\Components\Repository;

use App\Events\Repository\GitHubRepoForksFetched;
use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;

class FetchGitHubRepoForks extends Command
{
    protected $signature = 'dashboard:fetch-github-repo-forks';

    protected $description = 'Fetch GitHub repository forks';

    public function handle(GitHubApi $gitHub)
    {
        $this->info('Fetching GitHub repo repository forks');

        $userName = config('services.github.username');
        $repoName = config('services.github.repo');

        $forks = $gitHub
            ->fetchRepoForks($userName, $repoName)
            ->pipe(function (Collection $forks) use (
                $gitHub, $userName, $repoName
            ) {
                $converted = collect($forks->map(function (array $fork) use ($gitHub) {
                    return [
                        'name' => $fork['full_name'],
                        'commits' => $gitHub->fetchRepoCommits(
                            $fork['owner']['login'],
                            $fork['name']
                        )->count(),
                        'stars' => $fork['stargazers_count']
                    ];
                }));

                return $converted
                    ->sortByDesc('commits')
                    ->slice(0, 8);
            });

        event(new GitHubRepoForksFetched($forks->toArray()));

        $this->info('Repo forks loaded!');
    }
}
