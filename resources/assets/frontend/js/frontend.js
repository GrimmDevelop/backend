import Vue from 'vue';

import App from './App';

import Icon from "./components/ui/Icon";

Vue.component('icon', Icon);

new Vue({
    el: '#app',

    render: (h) => h(App),
});
