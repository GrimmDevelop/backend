import '../bootstrap';

import typeahead from '../utils/Typeahead.vue';

new window.Vue({
    el: '#app-container',

    data: {
        associations: [],
        person: {
            id: null,
        },
        createEntry: '',
        placeholder: ''
    },

    mounted() {
        this.$nextTick(() => {
            if (typeof window.PERSON_MODEL !== 'undefined') {
                this.person = window.PERSON_MODEL;
            }

            this.$refs.searchPerson.focus();
        });
    },

    methods: {
        fillOccurrenceForm(person) {
            this.personSelected(person);
        },

        personSelected(person) {
            this.person = person;
            this.placeholder = person.last_name + ', ' + person.first_name;
        },

        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        typeahead
    }
});