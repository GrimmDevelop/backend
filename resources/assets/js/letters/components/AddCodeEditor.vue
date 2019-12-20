<template>
    <div class="modal fade" :id="modal" role="dialog" aria-labelledby="addItemTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Schließen">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addItemTitle">
                        {{ title }} hinzufügen
                    </h4>
                </div>
                <div class="form-group" rel="createItemForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputInformationCode">Code: </label>
                            <input type="text" id="inputInformationCode" class="form-control" v-model="createCode">
                        </div>
                        <div>
                            <label for="inputErrorGenerated">Error Generated: </label>
                            <input type="checkbox" id="inputErrorGenerated" class="checkbox-inline"
                                   v-model="createErrorGenerated">
                        </div>
                        <div>
                            <label for="inputInternal">Internal: </label>
                            <input type="checkbox" id="inputInternal" class="checkbox-inline" v-model="createInternal">
                        </div>
                        <div v-if="errors.length" class="list-group list-group-item-text">
                            <ul>
                                <li v-for="(error, index) in errors" :key="`error-${index}`" class="text-danger">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Schließen
                        </button>
                        <button type="button" class="btn btn-primary" @click.prevent="storeItem">Speichern</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['url', 'modal', 'title', 'on-stored'],

        data() {
            return {
                errors: [],
                createCode: '',
                createErrorGenerated: false,
                createInternal: false
            };
        },

        mounted() {
            this.$nextTick(() => {
                window.$('#' + this.modal).on('shown.bs.modal', () => {
                    window.$(this.$refs.createCodeField).focus();
                });

            });
        },

        methods: {
            storeItem() {
                this.$http.post(this.url, {
                    codeName: this.createCode,
                    codeErrorGenerated: this.createErrorGenerated,
                    codeInternal: this.createInternal
                }).then(({data}) => {
                    this.onStored(data);

                    if (!this.createErrorGenerated) {
                        window.$('#' + this.modal).modal('hide');

                        this.$root.$emit('code-added', Object.keys(data).pop());
                    }

                    this.errors = [];
                    this.createCode = '';
                    this.createErrorGenerated = false;
                    this.createInternal = false;
                }).catch(err => {
                    this.errors = [];
                    let items = err.response.data.errors;

                    Object.keys(items).forEach(key => {
                        Object.keys(items[key]).forEach((element) => {
                            this.errors.push(items[key][element]);
                        });
                    });
                });
            }
        }
    };
</script>