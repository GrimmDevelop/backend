import '../bootstrap';

import ApparatusesIndex from './apparatuses/ApparatusesIndex';
import CommentsIndex from './comments/CommentsIndex';

new window.Vue({
    el: '#app-container',

    data: {},

    methods: {
        save() {
            this.$refs.comments.save();
            this.$refs.apparatuses.save();
        }
    },

    components: {
        ApparatusesIndex,
        CommentsIndex,
    }
});