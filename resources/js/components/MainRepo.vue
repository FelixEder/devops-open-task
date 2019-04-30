<template>
    <tile :position="position">
        <div class="grid gap-padding h-full markup">
            <span class="main_repo_name">{{mainRepoName}}</span>
            <ul class="align-self-center">
                <li>
                    <span v-html="emoji('✨')" />
                    <span class="font-bold variant-tabular">{{ formatNumber(githubStars) }}</span>
                </li>
                <li>
                    <span>Forks</span>
                    <span class="font-bold variant-tabular">{{ formatNumber(githubForks) }}</span>
                </li>
                <li>
                    <span>Issues</span> <span class="font-bold variant-tabular">{{ formatNumber(githubIssues) }}</span>
                </li>
                
                <li>
                    <span>Commits</span> <span class="font-bold variant-tabular">{{ formatNumber(githubCommits) }}</span>
                </li>
            </ul>
        </div>
    </tile>
</template>

<script>
import { emoji, formatNumber } from '../helpers';
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            githubStars: 0,
            githubIssues: 0,
            githubForks: 0,
            githubCommits: 0
        };
    },

    methods: {
        emoji,
        formatNumber,

        getEventHandlers() {
            return {
                'Repository.GitHubRepoFetched': response => {
                    console.log("Hello");
                    console.log(response);
                    this.mainRepoName = response.name;
                    this.githubStars = response.stars;
                    this.githubIssues = response.issues;
                    this.githubForks = response.forks;
                    this.githubCommits = response.commits;
                }
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'main-repo'
            };
        },
    },
};
</script>
