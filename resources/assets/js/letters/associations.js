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
            if (window.PERSON_MODEL !== null) {
                this.person = window.PERSON_MODEL;
            }

            window.$('#addOccurrence').on('shown.bs.modal', () => {
                this.$refs.storeOccurrence.focus();
            });
        });
    },

    methods: {
        fillOccurrenceForm(person) {
            this.personSelected(person);
        },

        personSelected(person) {
            this.person = person;
            this.placeholder = person.last_name + ', ' + person.first_name;
            this.$refs.pageField.focus();
        },

        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        typeahead
    }
});