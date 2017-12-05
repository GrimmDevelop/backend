import '../bootstrap';

import VueLocalStorage from 'vue-localstorage';

Vue.use(VueLocalStorage);

new Vue({
    el: '#letters',

    localStorage: {
        columns: {
            type: Object,
            default: {
                id_till_1992: false,
                id_till_1997: false,
                code: true,
                valid: false,
                date: true,
                couvert: false,
                copy_owned: false,
                language: false,
                inc: false,
                copy: false,
                attachment: false,
                directory: false,
                handwriting_location: false,
                senders: true,
                from: true,
                from_id: false,
                from_source: false,
                from_date: false,
                receive_annotation: false,
                reconstructed_from: false,
                receivers: true,
                to: true,
                to_id: false,
                to_date: false,
                reply_annotation: false,
            }
        }
    },

    data: {
        letters: window.LETTERS.data,
        columns: {}
    },

    mounted() {
        this.$nextTick(() => {
            this.columns = this.$localStorage.get('columns');
        });
    },

    methods: {
        toggleColumn(column) {
            this.columns[column] = !this.columns[column];

            this.$localStorage.set('columns', this.columns);
        },

        filter(column, letter) {
            if (column == 'from' || column == 'to') {
                if (letter[column] != null) {
                    return letter[column].historical_name;
                } else {
                    return '[unbekannt]';
                }
            }

            if (column == 'senders') {
                return letter.person_associations.filter((item) => {
                    return item.type == 0;
                }).map((item) => {
                    return item.assignment_source;
                }).join(' / ');
            }

            if (column == 'receivers') {
                return letter.person_associations.filter((item) => {
                    return item.type == 1;
                }).map((item) => {
                    return item.assignment_source;
                }).join(' / ');
            }

            return letter[column];
        }
    }
});