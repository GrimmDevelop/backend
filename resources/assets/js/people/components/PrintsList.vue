<template>
    <div role="tabpanel" class="tab-pane active" id="prints">
        <div class="add-button" v-if="!deleted">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addPrint">
                <span class="fa fa-plus"></span> Druck hinzufügen
            </button>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th colspan="2">Eintrag</th>
                <th colspan="2">Jahr</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="print in prints" is="in-place-editor"
                :key="`print-${print.id}`"
                :print-id="print.id" :print-entry="print.entry" :print-year="print.year"
                :base-url="indexUrl" :editable="!deleted"
                @stored="loadPrints">
            </tr>
            </tbody>
        </table>
        <div class="modal fade" id="addPrint" role="dialog" aria-labelledby="addPrintTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Schließen">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addPrintTitle">Druck hinzufügen</h4>
                    </div>
                    <form @submit.prevent="storePrint" id="createPrintForm"
                          :action="storeUrl"
                          class="form-inline" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="entry">Eintrag: </label>
                                <input type="text" class="form-control form-control-sm" name="entry"
                                       ref="createEntryField" v-model="createEntry">
                            </div>
                            <div class="form-group">
                                <label for="year">Jahr: </label>
                                <input type="text" class="form-control form-control-sm" name="year"
                                       v-model="createYear">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Schließen
                            </button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import InPlaceEditor from './PrintInPlaceEditor.vue';

    export default {
        name: "PrintsList",

        props: {
            storeUrl: {required: true},
            indexUrl: {required: true},
            deleted: {default: false}
        },

        data() {
            return {
                prints: [],
                createEntry: '',
                createYear: ''
            };
        },

        mounted() {
            this.loadPrints();

            this.$nextTick(() => {
                window.$('#addPrint').on('shown.bs.modal', () => {
                    this.$refs.createEntryField.focus();
                });
            });
        },

        methods: {
            loadPrints() {
                this.$http.get(this.indexUrl).then(({data}) => {
                    this.prints = data;
                });
            },

            storePrint() {
                this.$http.post(this.storeUrl, {
                    entry: this.createEntry,
                    year: this.createYear
                }).then(({data}) => {
                    this.prints = data;
                    this.createEntry = '';
                    this.createYear = '';
                    window.$('#addPrint').modal('hide');
                });
            }
        },

        components: {
            InPlaceEditor,
        }
    };
</script>
