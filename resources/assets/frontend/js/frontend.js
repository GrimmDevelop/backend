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
    mode: "history",
    routes,
});

import store from "./store";

new Vue({
    el: '#app',

    router: router,
    store: store,

    render: (h) => h(App),
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
// import 'pusher-js'
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});