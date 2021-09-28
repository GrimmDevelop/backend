import Vue from 'vue';
import axios from "axios";

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.Laravel.pusherAppKey,
    cluster: window.Laravel.pusherAppCluster,
    forceTLS: true
});

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.prototype.$http = axios;

// global components
import VueSelect from "vue-select";
import Icon from "./components/ui/Icon";

Vue.component('icon', Icon);
Vue.component('v-select', VueSelect);

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
