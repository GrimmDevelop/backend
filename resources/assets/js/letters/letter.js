import '../bootstrap';

import InPlaceEditor from './components/PrintInPlaceEditor.vue';
import InheritanceInPlaceEditor from './components/InheritanceInPlaceEditor.vue';

Vue.component('in-place', InPlaceEditor);
Vue.component('inheritance-in-place', InheritanceInPlaceEditor);

new Vue({
    el: '#prints',

    data: {
        prints: [],
        createEntry: '',
        createYear: ''
    },

    mounted() {
        this.$nextTick(() => {
            let url = BASE_URL + '/prints';

            axios.get(url).then(({ data }) => {
                this.prints = data;
            });

            $('#addPrint').on('shown.bs.modal', (e) => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storePrint() {
            let url = $('#createPrintForm').attr('action');

            console.log(url);

            axios.post(url, {
                entry: this.createEntry,
                year: this.createYear
            }).then(({ data }) => {
                this.prints = data;
                this.createEntry = '';
                this.createYear = '';
                $('#addPrint').modal('hide');
            });
        }
    }
});

new Vue({
    el: '#inheritances',

    data: {
        inheritances: [],
        createEntry: ''
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/inheritances';

            axios.get(url).then(({ data }) => {
                this.inheritances = data;
            });

            $('#addInheritance').on('shown.bs.modal', (e) => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storeInheritance() {
            var url = $('#createInheritanceForm').attr('action');

            axios.post(url, {
                entry: this.createEntry
            }).then(({ data }) => {
                this.inheritances = data;
                this.createEntry = '';
                $('#addInheritance').modal('hide');
            });
        }
    }
});