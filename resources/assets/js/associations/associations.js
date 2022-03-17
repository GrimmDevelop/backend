import '../bootstrap';

import typeahead from '../utils/Typeahead.vue';

new window.Vue({
    el: '#app-container',

    data: {
        form: null,
        associations: [],
        person: {
            id: null,
        },
        createEntry: ''
    },

    mounted() {
        this.$nextTick(() => {
            this.form = this.$refs.associationsForm;

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
            if(this.$refs.pageField) {
                this.$refs.pageField.focus();
            }
        },

        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        typeahead
    }
});