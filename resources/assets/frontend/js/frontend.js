import Vue from 'vue';
import axios from "axios";

// tailwindcss 2.0 tinymce
require('tinymce');
require('tinymce/themes/silver');

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

new Vue({
    el: '#app',

    router,

    render: (h) => h(App),
});
