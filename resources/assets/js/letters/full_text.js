import '../bootstrap';

import FullTextIndex from './full_text/FullTextIndex';

new window.Vue({
    el: '#app-container',

    data: {},

    methods: {
        save() {
            this.$refs.full_text.save();
        }
    },

    components: {
        FullTextIndex
    }
});