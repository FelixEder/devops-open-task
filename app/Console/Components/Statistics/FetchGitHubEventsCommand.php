<?php

namespace App\Console\Components\Statistics;

use App\Events\Statistics\GitHubTotalsEvents;
use Illuminate\Console\Command;
use App\Services\GitHub\GitHubApi;
use Illuminate\Support\Collection;
use App\Events\Statistics\GitHubTotalsFetched;

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



        event(new GitHubTotalsEvents($totals));

        $this->info('All done right!');
    }
}
