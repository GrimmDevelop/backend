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
                            <label for="inputCodes">Code: </label>
                            <select id="inputCodes" v-model="createCode" ref="createCodeField">
                                <option v-for="code in codesItem" :key="code.id" :value="code.id" class="form-control"
                                        v-text="code.name">
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputData">Werte: </label>
                            <textarea rows="5" cols="30" class="form-control" name="data"
                                      id="inputData" v-model="createdData">
                            </textarea>
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
        props: ['url', 'modal', 'codesItem', 'title', 'on-stored'],

        data() {
            return {
                errors: [],
                createCode: '',
                createdData: '',
            };
        },

        mounted() {
            this.$root.$on('code-added', (code) => {

                window.$('.nav-tabs a[href="#information"]').tab('show');
                window.$('#' + this.modal).modal('show');

                this.createCode = code;
            });

            this.$nextTick(() => {
                window.$('#' + this.modal).on('shown.bs.modal', () => {
                    window.$(this.$refs.createCodeField).focus();
                });
            });
        },

        methods: {
            storeItem() {
                this.$http.post(this.url, {
                    code: this.createCode,
                    data: this.createdData
                }).then(({data}) => {
                    this.onStored(data);

                    this.createCode = '';
                    this.createdData = '';
                    this.errors = [];

                    window.$('#' + this.modal).modal('hide');
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