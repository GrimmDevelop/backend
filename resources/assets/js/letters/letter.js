import '../bootstrap';

import InPlaceEditor from './components/InPlaceEditor.vue';
import AddItemEditor from './components/AddItemEditor.vue';


window.Vue.component('in-place-editor', InPlaceEditor);
window.Vue.component('add-item-editor', AddItemEditor);

new window.Vue({
    el: '#app-container',

    data: {
        form: null,
        prints: [],
        transcriptions: [],
        attachments: [],
        drafts: [],
        facsimiles: [],
        auctionCatalogues: [],
    },

    computed: {
        letterId() {
            return window.letterId;
        }
    },

    mounted() {
        this.form = this.$refs.letterForm;

        this.$http.get(`/api/letters/${this.letterId}/prints`).then(({data}) => {
            this.prints = data;
        });

        this.$http.get(`/api/letters/${this.letterId}/transcriptions`).then(({data}) => {
            this.transcriptions = data;
        });

        this.$http.get(`/api/letters/${this.letterId}/attachments`).then(({data}) => {
            this.attachments = data;
        });

        this.$http.get(`/api/letters/${this.letterId}/drafts`).then(({data}) => {
            this.drafts = data;
        });

        this.$http.get(`/api/letters/${this.letterId}/facsimiles`).then(({data}) => {
            this.facsimiles = data;
        });

        this.$http.get(`/api/letters/${this.letterId}/auction-catalogues`).then(({data}) => {
            this.auctionCatalogues = data;
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

        storedCatalogue(catalogues) {
            this.auctionCatalogues = catalogues;
        },

        deletePersonAssociation(associationId) {
            if (confirm('Soll die Verknüpfung wirklich gelöscht werden?')) {
                this.$http.delete(`/letters/${this.letterId}/associations/${associationId}`).then(() => {
                    location.reload();
                });
            }
        }
    },
});
