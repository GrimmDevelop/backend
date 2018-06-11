import '../bootstrap';

import InPlaceEditor from './components/InPlaceEditor.vue';
import AddItemEditor from './components/AddItemEditor.vue';
import AddInformationEditor from './components/AddInformationEditor.vue';

Vue.component('in-place-editor', InPlaceEditor);
Vue.component('add-item-editor', AddItemEditor);
Vue.component('add-information-editor', AddInformationEditor);

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
    el: '#transcriptions',

    data: {
        transcriptions: []
    },

    mounted() {
        this.$nextTick(() => {
            let url = BASE_URL + '/transcriptions';

            axios.get(url).then(({data}) => {
                this.transcriptions = data;
            });
        });
    },

    methods: {
        stored(transcriptions) {
            this.transcriptions = transcriptions;
        }
    }
});

new Vue({
    el: '#attachments',

    data: {
        attachments: []
    },

    mounted() {
        this.$nextTick(() => {
            let url = BASE_URL + '/attachments';

            axios.get(url).then(({data}) => {
                this.attachments = data;
            });
        });
    },

    methods: {
        stored(attachments) {
            this.attachments = attachments;
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

new Vue({
    el: '#information',

    data: {
        information: [],
        codes: []
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/information';

            axios.get(url).then(({data}) => {
                this.information = data['information'];
                this.codes = data['codes'];
            });
        });
    },

    methods: {
        stored(information) {
            this.information = information;
        }
    }
});