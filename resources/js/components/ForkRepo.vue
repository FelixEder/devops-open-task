<template>
    <tile :position="position">
        <div class="grid gap-padding h-full markup">
            <span>{{ name }}</span>
            <ul class="align-self-center">
                <li>
                    <span v-html="emoji('✨')" />
                    <span class="font-bold variant-tabular">{{ formatNumber(stars) }}</span>
                </li>
                <li>
                    <span>Commits</span> <span class="font-bold variant-tabular">{{ formatNumber(commits) }}</span>
                </li>
            </ul>
        </div>
    </tile>
</template>

<script>
import { emoji, formatNumber } from '../helpers';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [saveState],

    props: ['commits', 'stars', 'name', 'index'],

    computed: {
        position: function () {
            let column = String.fromCharCode(98 + (this.index % 4));
            let row = (this.index/4);
            return `${column}${1+row*12}:${column}${12+row*12}`;
        }
    },

    methods: {
        emoji,
        formatNumber,

        getSaveStateConfig() {
            return {
                cacheKey: 'fork-repo'
            };
        },
    },
};
</script>
