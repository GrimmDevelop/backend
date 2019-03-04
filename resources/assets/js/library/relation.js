import '../bootstrap';

import Typeahead from '../utils/Typeahead.vue';

new window.Vue({
    el: '#app-container',

    data: {
        person: {
            id: null
        },
    },

    mounted() {

    },

    methods: {
        personSelected(person) {
            this.person = person;
        },

        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        Typeahead
    }
});