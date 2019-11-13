import '../bootstrap';

import LetterTextIndex from './lettertext/LetterTextIndex';

new window.Vue({
    el: '#app-container',

    data: {},

    methods: {
        save() {
            this.$refs.full_text.save();
        }
    },

    components: {
        LetterTextIndex
    }
});