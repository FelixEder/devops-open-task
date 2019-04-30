<template>
    <div
        class="fixed pin grid gap-spacing w-screen h-screen p-spacing font-normal leading-normal text-default bg-screen"
        :class="mode"
    >
        <slot></slot>
        <fork-repo v-for="(fork, index) in githubForks" v-bind:key="index" v-bind="fork" v-bind:index="index"></fork-repo>
    </div>
</template>

<script>
import echo from '../mixins/echo';
import saveState from 'vue-save-state';
import ForkRepo from './ForkRepo';

export default {
    mixins: [echo, saveState],

    components: {
        ForkRepo
    },

    data() {
        return {
            mode: 'light-mode',
            githubForks: []
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Dashboard.UpdateAppearance': response => {
                    this.mode = response.mode;
                },
                'Repository.GitHubRepoForksFetched': response => {
                    this.githubForks = response.forks;
                }
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'dashboard'
            };
        },
    },
};
</script>
