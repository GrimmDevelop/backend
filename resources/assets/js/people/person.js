import '../bootstrap';

import InPlaceEditor from './components/PrintInPlaceEditor.vue';
import InheritanceInPlaceEditor from './components/InheritanceInPlaceEditor.vue';

import levenshtein from '../utils/Levenshtein';

window.Vue.component('in-place', InPlaceEditor);
window.Vue.component('inheritance-in-place', InheritanceInPlaceEditor);


new window.Vue({
    el: '#prints',

    data: {
        prints: [],
        createEntry: '',
        createYear: ''
    },

    mounted() {
        this.$nextTick(() => {
            let url = window.BASE_URL + '/prints';

            window.axios.get(url).then(({data}) => {
                this.prints = data;
            });

            window.$('#addPrint').on('shown.bs.modal', () => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storePrint() {
            let url = window.$('#createPrintForm').attr('action');

            window.axios.post(url, {
                entry: this.createEntry,
                year: this.createYear
            }).then(({data}) => {
                this.prints = data;
                this.createEntry = '';
                this.createYear = '';
                window.$('#addPrint').modal('hide');
            });
        }
    }
});

new window.Vue({
    el: '#inheritances',

    data: {
        inheritances: [],
        createEntry: ''
    },

    mounted() {
        this.$nextTick(() => {
            let url = window.BASE_URL + '/inheritances';

            window.axios.get(url).then(({data}) => {
                this.inheritances = data;
            });

            window.$('#addInheritance').on('shown.bs.modal', () => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storeInheritance() {
            let url = window.$('#createInheritanceForm').attr('action');

            window.axios.post(url, {
                entry: this.createEntry
            }).then(({data}) => {
                this.inheritances = data;
                this.createEntry = '';
                window.$('#addInheritance').modal('hide');
            });
        }
    }
});

new window.Vue({
    el: '#app-container',
    data: {
        form: null
    },
    mounted() {
        this.form = this.$refs.personForm;
    }
});

/**
 * On save, we calculate the change in the name and according to that,
 * we will ask if the user wants to really change the entry
 * to prevent accidental overwriting.
 */
window.$('#person-editor').on('submit', function (event) {
    let prevLastName = window.$('input[name=prev_last_name]').val();
    let prevFirstName = window.$('input[name=prev_first_name]').val();
    let prevName = `${prevLastName}, ${prevFirstName}`;

    let currentLastName = window.$('input[name=last_name]').val();
    let currentFirstName = window.$('input[name=first_name]').val();
    let currentName = `${currentLastName}, ${currentFirstName}`;

    let distance = levenshtein(prevName, currentName);

    if (distance > 3) {
        let message = `Der Name wurde an ${distance} Stellen bearbeitet. Soll der Datensatz wirklich geändert werden?\n\nBisheriger Name: ${prevName}\n\nNeuer Name: ${currentName}`;
        if (!confirm(message)) {
            event.preventDefault();
        }
    }
});
