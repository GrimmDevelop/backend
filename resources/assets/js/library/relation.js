import '../bootstrap';

import Typeahead from '../utils/Typeahead.vue';

new Vue({
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