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
            axios.get(BASE_URL + '/codes').then(({data}) => {
                this.codes = data;

                axios.get(BASE_URL + '/information').then(({data}) => {
                    this.information = data;
                });
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

        storedCode(codes) {
            this.codes = codes;
        },

        removedInformation(index) {
            this.information.splice(index, 1);
        },

        removedCode(index) {
            try {
                // let len = this.information.length;
                // for(var i=0;i<len;i++)
                // {
                //     if(this.information[i].letter_code_id===index)
                //     {
                //         this.delete(this.information,index);
                //         this.removedInformation(index);
                //     }
                // }
                axios.get(BASE_URL + '/information').then(({data}) => {
                    this.information = data;
                });

            } catch (e) {

                console.error(e.toString());
            }
        },
        updatedCode(code) {
            try {

                this.codes[code.id].name = code.name;
                this.codes[code.id].error_generated = code.error_generated;
                this.codes[code.id].internal = code.internal;

                this.storedCode(this.codes);

            } catch (e) {

                console.error(e.toString());
            }
        }
    }
});
