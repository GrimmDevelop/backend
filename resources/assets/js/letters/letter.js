import '../bootstrap';

import InPlaceEditor from './components/InPlaceEditor.vue';
import AddItemEditor from './components/AddItemEditor.vue';

Vue.component('in-place-editor', InPlaceEditor);
Vue.component('add-item-editor', AddItemEditor);

new Vue({
    el: '#prints',

    data: {
        prints: []
    },

    mounted() {
        this.$nextTick(() => {
            let url = BASE_URL + '/prints';

            axios.get(url).then(({data}) => {
                this.prints = data;
            });
        });
    },

    methods: {
        stored(prints) {
            this.prints = prints;
        }
    }
});

new Vue({
    el: '#drafts',

    data: {
        drafts: []
    },

    mounted() {
        this.$nextTick(() => {
            let url = BASE_URL + '/drafts';

            axios.get(url).then(({data}) => {
                this.drafts = data;
            });
        });
    },

    methods: {
        stored(drafts) {
            this.drafts = drafts;
        }
    }
});

new Vue({
    el: '#facsimiles',

    data: {
        facsimiles: []
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/facsimiles';

            axios.get(url).then(({data}) => {
                this.facsimiles = data;
            });
        });
    },

    methods: {
        stored(facsimiles) {
            this.facsimiles = facsimiles;
        }
    }
});