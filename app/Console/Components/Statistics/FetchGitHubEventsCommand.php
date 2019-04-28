<?php

namespace App\Console\Components\Statistics;

use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;

class FetchGitHubEventsCommand extends Command
{
    protected $signature = 'dashboard:fetch-github-events';

    protected $description = 'Fetch GitHub events';

    public function handle(GitHubApi $gitHub)
    {
        $this->info('Fetching GitHub events');

        $userName = config('services.github.username');
        $repoName = config('services.github.repo');

        $totals = $gitHub
            ->fetchEvents($userName, $repoName)
            ->pipe(function (Collection $repos) use ($gitHub, $userName) {
                return [
                    'type' => $repos[0]['type']
                ];
            });



        event(new GitHubCodeDayRepo($totals));

        $this->info('All done right!');
    }
}
