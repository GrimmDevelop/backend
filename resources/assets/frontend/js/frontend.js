import Vue from 'vue';
import axios from "axios";

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

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
import { randomString } from "@/js/utils";

let token = () => {
    if (!window.localStorage.getItem('user-token')) {
        window.localStorage.setItem('user-token', randomString(32));
    }

    return window.localStorage.getItem('user-token');
};

store.commit('set_user', token());

new Vue({
    el: '#app',

    router: router,
    store: store,

    render: (h) => h(App),
});
