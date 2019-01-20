import '../bootstrap';

import Upload from '../utils/Upload.vue';

new window.Vue({
    el: '#app-container',

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