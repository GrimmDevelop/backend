import '../bootstrap';

import InPlaceEditor from './components/InPlaceEditor.vue';
import InPlaceInformationEditor from './components/InPlaceInformationEditor.vue';
import InPlaceCodeEditor from './components/InPlaceCodeEditor.vue';
import AddItemEditor from './components/AddItemEditor.vue';
import AddInformationEditor from './components/AddInformationEditor.vue';
import AddCodeEditor from './components/AddCodeEditor.vue' ;


Vue.component('in-place-editor', InPlaceEditor);
Vue.component('in-place-information-editor', InPlaceInformationEditor);
Vue.component('in-place-code-editor', InPlaceCodeEditor);
Vue.component('add-item-editor', AddItemEditor);
Vue.component('add-information-editor', AddInformationEditor);
Vue.component('add-code-editor', AddCodeEditor);

new Vue({
    el: '#app-container',

    data: {
        form: null,
        prints: [],
        transcriptions: [],
        attachments: [],
        drafts: [],
        facsimiles: [],
        information: [],
        codes: [],
    },

    mounted() {
        this.form = this.$refs.letterForm;

        this.$nextTick(() => {
            axios.get(BASE_URL + '/prints').then(({data}) => {
                this.prints = data;
            });

            axios.get(BASE_URL + '/transcriptions').then(({data}) => {
                this.transcriptions = data;
            });

            axios.get(BASE_URL + '/attachments').then(({data}) => {
                this.attachments = data;
            });

            axios.get(BASE_URL + '/drafts').then(({data}) => {
                this.drafts = data;
            });

            axios.get(BASE_URL + '/facsimiles').then(({data}) => {
                this.facsimiles = data;
            });

            axios.get(BASE_URL + '/information').then(({data}) => {
                this.information = data['information'];
                this.codes = data['codes'];
            });
        });
    },

    methods: {
        storedPrint(prints) {
            this.prints = prints;
        },

        storedTranscription(transcriptions) {
            this.transcriptions = transcriptions;
        },

        storedAttachment(attachments) {
            this.attachments = attachments;
        },

        storedDraft(drafts) {
            this.drafts = drafts;
        },

        storedFacsimile(facsimiles) {
            this.facsimiles = facsimiles;
        },

        storedInformation(information) {
            this.information = information;
        },

        removedInformation(index) {
            this.information.splice(index, 1);
        },

        storedCode(codes) {
            this.codes = codes;
        },

        removedCode(index) {
            this.codes.splice(index, 1);
        }
    }
});
