<template>
    <div :position="position">
        <fork-repo position="b1:b6" v-for="(fork, index) in githubForks" v-bind="fork" v-bind:index="index"></fork-repo>
    </div>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import ForkRepo from "./ForkRepo";

export default {
    components: {
        ForkRepo,
        Tile,
    },

    props: ['position'],

    mixins: [echo, saveState],

    data() {
        return {
            githubForks: []
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Repository.GitHubRepoForksFetched': response => {
                    this.githubForks = response.forks;
                }
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'fork-repos'
            };
        },
    },
};
</script>
