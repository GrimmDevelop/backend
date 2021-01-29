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

new Vue({
    el: '#app',

    mounted() {
        console.log(window.Laravel.component);
        console.log(window.Laravel.params);
    },
});
