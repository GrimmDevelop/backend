import Vue from "vue";
import axios from "axios";

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

/*try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}*/

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = Vue;

Vue.prototype.$http = axios;

import PortalVue from 'portal-vue';
import StatusBar from './ui/components/StatusBar';

window.Vue.use(PortalVue);

window.Vue.component('status-bar', StatusBar);
