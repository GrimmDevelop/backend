import '../bootstrap';

import LetterTextIndex from './lettertext/LetterTextIndex';

new window.Vue({
    el: '#app-container',

    data: {},

    methods: {
        save() {
            this.$refs.lettertext.save();
        }
    },

    components: {
        LetterTextIndex
    }
});