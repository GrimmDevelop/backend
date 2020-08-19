<template>
    <modal :namespace="modal" :ref="`${modal}Modal`" @shown="shown">
        <template slot="title">
            {{ title }} hinzufügen
        </template>

        <template slot="body">
            <div class="m-2">
                <label :for="`inputEntry${modal}`">Eintrag: </label>
                <input type="text" class="form-control form-control-sm"
                       :id="`inputEntry${modal}`" name="entry"
                       ref="focusField" v-model="createEntry">
            </div>
            <div class="m-2">
                <label :for="`inputYear${modal}`">Jahr: </label>
                <input type="text" class="form-control form-control-sm"
                       :id="`inputYear${modal}`" name="year"
                       v-model="createYear">
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
                createEntry: '',
                createYear: '',
            };
        },

        methods: {
            shown() {
                this.$refs.focusField.focus();
            },

            storeItem() {
                this.$http.post(this.url, {
                    entry: this.createEntry,
                    year: this.createYear
                }).then(({data}) => {
                    this.onStored(data);

                    this.createEntry = '';
                    this.createYear = '';

                    window.$('#' + this.modal).modal('hide');
                });
            }
        },

        components: {Modal},
    };
</script>
