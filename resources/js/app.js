import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Dashboard from './components/Dashboard';
import Calendar from './components/Calendar';
import InternetConnection from './components/InternetConnection';
import TimeWeather from './components/TimeWeather';
import MainRepo from './components/MainRepo';
import TileTimer from './components/TileTimer';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Calendar,
        InternetConnection,
        TimeWeather,
        TileTimer,
        MainRepo
    },

    created() {
        let config = {
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            wsHost: window.location.hostname,
            wsPath: window.dashboard.clientConnectionPath,
            wsPort: window.dashboard.wsPort
        };

        if (window.dashboard.environment === 'local') {
            config.wsPort = 6001;
        }

        this.echo = new Echo(config);
    },
});
