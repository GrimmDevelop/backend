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
                <div class="form-inline" rel="createItemForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="entry">Eintrag: </label>
                            <input type="text" class="form-control input-sm"
                                   name="entry"
                                   ref="createEntryField" v-model="createEntry">
                        </div>
                        <div class="form-group">
                            <label for="year">Jahr: </label>
                            <input type="text" class="form-control input-sm" name="year"
                                   v-model="createYear">
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
                createEntry: '',
                createYear: '',
            };
        },

        mounted() {
            this.$nextTick(() => {
                $('#' + this.modal).on('shown.bs.modal', (e) => {
                    $(this.$refs.createEntryField).focus();
                });
            });
        },

        methods: {
            storeItem() {
                console.log(this.url);

                axios.post(this.url, {
                    entry: this.createEntry,
                    year: this.createYear
                }).then(({data}) => {
                    this.onStored(data);

                    this.createEntry = '';
                    this.createYear = '';

                    $('#' + this.modal).modal('hide');
                });
            }
        }
    }
</script>