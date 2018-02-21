import Vue from 'vue';

import Upload from '../utils/Upload.vue';

new Vue({
    el: '#letters-scans',

    data: {
        flow: null,
        fileSelected: false
    },

    mounted () {

    },

    components: {
        Upload
    }
});