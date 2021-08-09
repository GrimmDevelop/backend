import Vue from 'vue';
import axios from "axios";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.prototype.$http = axios;

// global components
import Icon from "./components/ui/Icon";

Vue.component('LetterEditor', LetterEditor);
Vue.component('icon', Icon);

import App from './App';

import VueRouter from "vue-router";

VueRouter.install(Vue);

import routes from "./routes/routes";
import LetterEditor from "../../../views/letters/LetterEditor";

const router = new VueRouter({
    routes,
});

new Vue({
    el: '#app',

    router,

    render: (h) => h(App),
});
