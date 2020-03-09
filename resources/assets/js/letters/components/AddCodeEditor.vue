<template>
    <modal :namespace="modal" :ref="`${modal}Modal`" @shown="shown">
        <template slot="title">
            {{ title }} hinzufügen
        </template>

        <template slot="body">
            <div class="m-2">
                <label for="inputInformationCode">Code: </label>
                <input ref="focusField" type="text" id="inputInformationCode" class="form-control" v-model="createCode">
            </div>
            <div class="m-2">
                <label for="inputErrorGenerated">
                    <input type="checkbox" id="inputErrorGenerated" class="form-check-inline"
                           v-model="createErrorGenerated">
                    Error Generated
                </label>
            </div>
            <div class="m-2">
                <label for="inputInternal">
                    <input type="checkbox" id="inputInternal" class="form-check-inline" v-model="createInternal">
                    Internal
                </label>
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
        props: ['url', 'modal', 'title', 'on-stored'],

        data() {
            return {
                errors: [],
                createCode: '',
                createErrorGenerated: false,
                createInternal: false
            };
        },

        methods: {
            shown() {
                this.$refs.focusField.focus();
            },

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
        },

        components: {Modal},
    };
</script>
