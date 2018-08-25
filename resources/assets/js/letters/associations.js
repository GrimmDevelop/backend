import '../bootstrap';

import typeahead from '../utils/Typeahead.vue';

new Vue({
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
            if (PERSON_MODEL !== null) {
                this.person = PERSON_MODEL;
            }

            $('#addOccurrence').on('shown.bs.modal', (e) => {
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