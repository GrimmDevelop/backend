<template>
    <div role="tabpanel" class="tab-pane" id="inheritances">
        <div class="add-button" v-if="!deleted">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addInheritance">
                <i class="fa fa-plus"></i> Nachlass hinzufügen
            </button>
        </div>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th colspan="3">Eintrag</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(inheritance, index) in inheritances" is="inheritance-in-place-editor"
                :key="`inheritance-${index}`"
                :inheritance-id="inheritance.id" :inheritance-entry="inheritance.entry"
                :base-url="indexUrl"
                :editable="!deleted"
                @saved="loadInheritances">
            </tr>
            </tbody>
        </table>
        <div class="modal fade" id="addInheritance" role="dialog" aria-labelledby="addInheritanceTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Schließen">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addInheritanceTitle">Nachlass hinzufügen</h4>
                    </div>
                    <form @submit.prevent="storeInheritance"
                          :action="storeUrl"
                          class="form-inline" id="createInheritanceForm" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputEntry">Eintrag: </label>
                                <input type="text" class="form-control input-sm"
                                       id="inputEntry" name="entry" ref="createEntryField" v-model="createEntry">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
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
    import InheritanceInPlaceEditor from './InheritanceInPlaceEditor.vue';

    export default {
        name: "InheritancesList",

        props: {
            indexUrl: {required: true},
            storeUrl: {required: true},
            deleted: {default: false},
        },

        data() {
            return {
                inheritances: [],
                createEntry: ''
            };
        },

        mounted() {
            this.loadInheritances();

            this.$nextTick(() => {
                window.$('#addInheritance').on('shown.bs.modal', () => {
                    this.$refs.createEntryField.focus();
                });
            });
        },

        methods: {
            loadInheritances() {
                window.axios.get(window.BASE_URL + '/inheritances').then(({data}) => {
                    this.inheritances = data;
                });
            },

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
        },

        components: {
            InheritanceInPlaceEditor,
        }
    };
</script>

<style scoped>

</style>