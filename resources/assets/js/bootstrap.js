window._ = require('lodash');

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

let axios = window.axios = require('axios');

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

let Vue = window.Vue = require('vue');

Vue.prototype.$http = axios;

import PortalVue from 'portal-vue';
import StatusBar from './ui/components/StatusBar';

window.Vue.use(PortalVue);

window.Vue.component('status-bar', StatusBar);
