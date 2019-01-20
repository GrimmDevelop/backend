<template>
    <tr v-if="existing" :class="{'bg-danger': this.selectedItem.error_generated}">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <select ref="codeInput" v-model="editingCode">
                <option v-for="itemCode in itemCodes" :key="itemCode.id" :value="itemCode.id" v-text="itemCode.name"
                        class="form-control" @keyup.enter="saveItem()">
                </option>
            </select>
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><i class="fa fa-edit"></i></a>
            {{ selectedItem.name }}
        </td>
        <td v-if="editing">
            <textarea rows="5" cols="30" class="form-control input-sm" v-model="editingData"
                      v-on:keyup.enter="saveItem()">
            </textarea>
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveItem()"><i
                    class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern
            </button>
        </td>
        <td colspan="2" v-if="!editing">{{ data }} <a href="#" v-on:click.prevent="deleteItem" v-if="editable"><i
                class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a></td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['itemId', 'itemCodes', 'selectedCode', 'itemData', 'baseUrl', 'editable'],

        data() {
            return {
                editing: false,
                existing: true,
                saving: false,
                selectedItem: '',
                code: '',
                data: '',
                editingCode: '',
                editingData: ''
            };
        },

        mounted() {
            this.selectedItem = this.selectedCode;
            this.code = this.selectedCode.id;
            this.data = this.itemData;
        },

        methods: {
            clickEdit() {
                if (this.editingData === '') {
                    this.editingData = this.data;
                }
                if (this.editingCode === '') {
                    this.editingCode = this.code;
                }
                this.editing = true;
                this.focusEntryInput();
            },

            stopEdit() {
                this.editing = false;
            },

            saveItem() {
                this.saving = true;
                window.axios.put(this.baseUrl + '/' + this.itemId, {
                    code: this.editingCode,
                    data: this.editingData
                }).then(({data}) => {
                    this.code = data.letter_code_id;
                    this.data = data.data;
                    this.selectedItem = this.itemCodes[data.letter_code_id];

                    this.editing = false;
                    this.saving = false;
                });
            },

            deleteItem() {
                if (window.confirm("Soll der Eintrag wirklich gelöscht werden?")) {
                    window.axios.delete(this.baseUrl + '/' + this.itemId).then(() => {
                        this.existing = false;
                        this.$emit('removed-info');
                    });
                }
            },

            focusEntryInput() {
                Vue.nextTick((function () {
                    this.$refs.codeInput.focus();
                }).bind(this));
            }
        }
    };
</script>
