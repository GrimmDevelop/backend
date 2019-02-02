import '../bootstrap';

import InPlaceEditor from './components/InPlaceEditor.vue';
import InPlaceInformationEditor from './components/InPlaceInformationEditor.vue';
import InPlaceCodeEditor from './components/InPlaceCodeEditor.vue';
import AddItemEditor from './components/AddItemEditor.vue';
import AddInformationEditor from './components/AddInformationEditor.vue';
import AddCodeEditor from './components/AddCodeEditor.vue';


window.Vue.component('in-place-editor', InPlaceEditor);
window.Vue.component('in-place-information-editor', InPlaceInformationEditor);
window.Vue.component('in-place-code-editor', InPlaceCodeEditor);
window.Vue.component('add-item-editor', AddItemEditor);
window.Vue.component('add-information-editor', AddInformationEditor);
window.Vue.component('add-code-editor', AddCodeEditor);

new window.Vue({
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
            window.axios.get(window.BASE_URL + '/prints').then(({data}) => {
                this.prints = data;
            });

            window.axios.get(window.BASE_URL + '/transcriptions').then(({data}) => {
                this.transcriptions = data;
            });

            window.axios.get(window.BASE_URL + '/attachments').then(({data}) => {
                this.attachments = data;
            });

            window.axios.get(window.BASE_URL + '/drafts').then(({data}) => {
                this.drafts = data;
            });

            window.axios.get(window.BASE_URL + '/facsimiles').then(({data}) => {
                this.facsimiles = data;
            });
            window.axios.get(window.BASE_URL + '/codes').then(({data}) => {
                this.codes = data;

                window.axios.get(window.BASE_URL + '/information').then(({data}) => {
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

        removedCode() {
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
                window.axios.get(window.BASE_URL + '/information').then(({data}) => {
                    this.information = data;
                });
            } catch (e) {
                //
            }
        },

        updatedCode(code) {
            try {
                this.codes[code.id].name = code.name;
                this.codes[code.id].error_generated = code.error_generated;
                this.codes[code.id].internal = code.internal;

                this.storedCode(this.codes);
            } catch (e) {
                //
            }
        }
    }
});
