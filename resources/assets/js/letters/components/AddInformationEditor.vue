<template>
    <modal :namespace="modal" :ref="`${modal}Modal`" @shown="shown">
        <template slot="title">
            {{ title }} hinzufügen
        </template>

        <template slot="body">
            <div class="m-2">
                <label for="inputCodes">Code: </label>
                <select class="form-control form-control-sm" id="inputCodes" v-model="createCode" ref="focusField">
                    <option v-for="code in codesItem" :key="code.id" :value="code.id" class="form-control"
                            v-text="code.name">
                    </option>
                </select>
            </div>
            <div class="m-2">
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
        </template>

        <template slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Schließen
            </button>
            <button type="button" class="btn btn-primary" @click.prevent="storeItem">Speichern</button>
        </template>
    </modal>
</template>

<script>
    import Modal from "../../ui/components/Modal";

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
        },

        methods: {
            shown() {
                this.$refs.focusField.focus();
            },

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
        },

        components: {Modal},
    };
</script>
