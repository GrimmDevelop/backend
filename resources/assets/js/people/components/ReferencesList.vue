<template>
    <div role="tabpanel" class="tab-pane" id="references">
        <div class="add-button" v-if="!deleted">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addReference">
                <i class="fa fa-plus"></i> Referenz hinzufügen
            </button>
        </div>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Notizen</th>
                <th class="action-column"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(reference, index) in references"
                :key="`reference-${index}`">
                <td>{{ reference.reference.id }}</td>
                <td>{{ fullName(reference.reference) }}</td>
                <td>{{ reference.notes }}</td>
                <td>
                    <span class="fa fa-trash"></span>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="modal fade" id="addReference" role="dialog" aria-labelledby="addReferenceTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Schließen">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addReferenceTitle">Referenz hinzufügen</h4>
                    </div>
                    <form @submit.prevent="storeReference" id="createReferenceForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <typeahead id="searchPerson"
                                           placeholder="Person suchen"
                                           src="/people/search?name="
                                           :prepare-response="prepareResponse"
                                           :on-hit="personSelected"
                                           empty="Es wurde keine Person gefunden!"
                                           refs="createReferencedPerson"
                                >
                                    <template slot="list-item" slot-scope="props">
                                        {{ fullName(props.item) }}
                                    </template>
                                </typeahead>
                                <input v-if="createReferencedPerson" class="form-control" :value="fullName(createReferencedPerson)" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputNote">Notizen: </label>
                                <textarea type="text" class="form-control input-sm" name="entry"
                                          ref="createNotesField" v-model="createNotes" rows="5"></textarea>
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
    import Typeahead from "../../utils/Typeahead";

    export default {
        name: "ReferencesList",

        props: {
            storeUrl: {required: true},
            indexUrl: {required: true},
            deleted: {default: false}
        },

        data() {
            return {
                references: [],
                createReferencedPerson: null,
                createNotes: ''
            };
        },

        mounted() {
            this.loadReferences();

            this.$nextTick(() => {
                window.$('#addReference').on('shown.bs.modal', () => {
                    this.$refs.createReferencedPerson.focus();
                });
            });
        },

        methods: {
            loadReferences() {
                window.axios.get(window.BASE_URL + '/references').then(({data}) => {
                    this.references = data;
                });
            },

            storeReference() {
                window.axios.post(this.storeUrl, {
                    reference: this.createReferencedPerson.id,
                    notes: this.createNotes
                }).then(({data}) => {
                    this.references = data;
                    this.createReferencedPerson = null;
                    this.createNotes = '';
                    window.$('#addReference').modal('hide');
                });
            },

            fullName(person) {
                if (!person) {
                    return '';
                }

                let name = person.last_name ? person.last_name : 'Unbekannt';

                if (person.is_organization || person.first_name === '') {
                    return name;
                }

                return person.last_name + ', ' + person.first_name;
            },

            prepareResponse(response) {
                return response.data;
            },

            personSelected(person) {
                this.createReferencedPerson = person;
            }
        },

        components: {Typeahead}
    };
</script>