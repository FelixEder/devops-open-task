<?php

namespace App\Console\Components\MainRepository;

use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;
use App\Events\MainRepository\GitHubCodeDayRepo;

class FetchGitHubMainRepoStatistics extends Command
{
    protected $signature = 'dashboard:fetch-github-main-repo-stats';

    protected $description = 'Fetch GitHub main repo statistics';

    public function handle(GitHubApi $gitHub)
    {
        $this->info('Fetching GitHub main repo statistics');

        $userName = config('services.github.username');
        $repoName = config('services.github.repo');

        $totals = $gitHub
            ->fetchMainRepoStats($userName, $repoName)
            ->pipe(function (Collection $repos) use ($gitHub, $userName) {
                //dd($repos);
                return [
                    'forks' => $repos->get('stargazers_count'),
                    'issues' => $repos->get('open_issues'),
                    'commits' => $repos->get('open_issues'),
                    'stars' => $repos->get('stargazers_count'),
                ];
            });

        event(new GitHubCodeDayRepo($totals));

        $this->info('Statistics loaded!');
    }
}
