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
                            <label for="code">Code: </label>
                            <select id="#codeSelect" v-model="createCode">
                                <option v-for="code in codesItem" :value="code.id" class="form-control"
                                        @change="createCode=$('#codeSelect').selectedIndex"
                                        ref="createCodeField" v-text="code.name">
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data">Werte: </label>
                            <textarea rows="5" cols="30" class="form-control" name="data"
                                      v-model="createdData">
                            </textarea>
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
                createCode: '',
                createdData: '',
            };
        },

        mounted() {
            this.$nextTick(() => {
                $('#' + this.modal).on('shown.bs.modal', (e) => {
                    $(this.$refs.createCodeField).focus();
                });
            });
        },

        methods: {
            storeItem() {
                console.log(this.url);

                axios.post(this.url, {
                    code: this.createCode,
                    data: this.createdData
                }).then(({data}) => {
                    this.onStored(data);

                    this.createCode = '';
                    this.createdData = '';

                    $('#' + this.modal).modal('hide');
                });
            }

        }
    }
</script>