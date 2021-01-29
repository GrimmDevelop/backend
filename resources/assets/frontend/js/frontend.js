import Vue from 'vue';

import axios from "axios";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.prototype.$http = axios;

// global components
import Icon from "./components/ui/Icon";

Vue.component('icon', Icon);

import App from './App';

import VueRouter from "vue-router";

VueRouter.install(Vue);

import routes from "./routes/routes";

const router = new VueRouter({
    routes,
});

import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.Laravel.broadcasting.key,
    cluster: window.Laravel.broadcasting.options.cluster,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
});

new Vue({
    el: '#app',

    router,

    render: (h) => h(App),
});
