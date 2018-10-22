<template>
    <tr v-if="existing" :class="{'bg-danger': code.error_generated}">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingCode.name" ref="EntryInput"
                   v-on:keyup.enter="saveItem()"/>
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><i class="fa fa-edit"></i></a> {{ code.name }}
        </td>
        <td v-if="editing">
            <input type="checkbox" class="checkbox" v-model="editingCode.error_generated">
        </td>
        <td colspan="2" v-if="!editing">
            <a v-if="code.error_generated"><i class="fa fa-check-circle"></i></a>
            <a v-else-if="!code.error_generated"><i class="fa fa-times-circle"></i></a>
        </td>
        <td v-if="editing">
            <input type="checkbox" class="checkbox" v-model="editingCode.internal">
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveItem()"><i
                    class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern
            </button>
        </td>
        <td cola="2" v-if="!editing">
            <a v-if="this.code.internal"><i class="fa fa-check-circle"></i></a>
            <a v-else-if="!code.internal"><i class="fa fa-times-circle"></i></a>
            <a href="#" v-on:click.prevent="deleteItem" v-if="editable"><i
                    class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a>
        </td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['itemId', 'itemCode', 'baseUrl', 'editable'],

        data() {
            return {
                editing: false,
                existing: true,
                saving: false,
                code: '',
                editingCode: '',
            }
        },

        mounted() {
            this.code = this.itemCode;
        },

        methods: {
            clickEdit() {
                if (this.editingCode == '') {
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
                axios.put(this.baseUrl + '/' + this.itemId, {
                    codeName: this.editingCode.name,
                    codeInternal: this.editingCode.internal,
                    codeErrorGenerated: this.editingCode.error_generated
                }).then(({data}) => {
                    this.editingCode.name = data.name;
                    this.editingCode.error_generated = data.error_generated;
                    this.editingCode.internal = data.internal;

                    this.$emit('updated-code', data);

                    this.editing = false;
                    this.saving = false;
                });
            },

            deleteItem() {
                if (window.confirm("Soll der Eintrag wirklich gelöscht werden?")) {
                    axios.delete(this.baseUrl + '/' + this.itemId).then((response) => {
                        this.existing = false;

                        this.$emit('removed-code');
                    });
                }
            },

            focusEntryInput() {
                Vue.nextTick((function () {
                    this.$refs.EntryInput.focus();
                }).bind(this));
            }
        }, watch: {
            codeName() {
                this.$emit('update:itemName', this.codeName);
            },
            codeErrorGenerated() {
                this.$emit('update:itemCodeErrorGenerated', this.codeErrorGenerated);
            },
            codeInternal() {
            }
        }
    }
</script>
