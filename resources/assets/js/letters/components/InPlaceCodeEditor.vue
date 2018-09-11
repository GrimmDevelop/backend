<template>
    <tr v-if="existing" :class="{'bg-danger': codeErrorGenerated}">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingName" ref="EntryInput"
                   v-on:keyup.enter="saveItem()"/>
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><i class="fa fa-edit"></i></a> {{ codeName }}
        </td>
        <td v-if="editing">
            <input type="checkbox" class="checkbox" v-model="editingErrorGenerated">
        </td>
        <td colspan="2" v-if="!editing">
            <a v-if="codeErrorGenerated"><i class="fa fa-check-circle"></i></a>
            <a v-else-if="!codeErrorGenerated"><i class="fa fa-times-circle"></i></a>
        </td>
        <td v-if="editing">
            <input type="checkbox" class="checkbox" v-model="editingInternal">
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveItem()"><i
                    class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern
            </button>
        </td>
        <td cola="2" v-if="!editing">
            <a v-if="codeInternal"><i class="fa fa-check-circle"></i></a>
            <a v-else-if="!codeInternal"><i class="fa fa-times-circle"></i></a>
            <a href="#" v-on:click.prevent="deleteItem" v-if="editable"><i
                    class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a>
        </td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['itemId', 'itemName', 'itemErrorGenerated', 'itemInternal', 'baseUrl', 'editable'],

        data() {
            return {
                editing: false,
                existing: true,
                saving: false,
                codeName: '',
                codeErrorGenerated: '',
                codeInternal: '',
                editingName: '',
                editingErrorGenerated: '',
                editingInternal: ''
            }
        },

        mounted() {
            this.codeName = this.itemName;
            this.codeErrorGenerated = this.itemErrorGenerated ? true : false;
            this.codeInternal = this.itemInternal ? true : false;
        },

        methods: {
            clickEdit() {
                if (this.editingName == '') {
                    this.editingName = this.codeName;
                }
                if (this.editingErrorGenerated == '') {
                    this.editingErrorGenerated = this.codeErrorGenerated;
                }
                if (this.editingInternal == '') {
                    this.editingInternal = this.codeInternal;
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
                    codeName: this.editingName,
                    codeInternal: this.editingInternal,
                    codeErrorGenerated: this.editingErrorGenerated
                }).then(({data}) => {
                    this.codeName = data.name;
                    this.codeInternal = data.internal;
                    this.codeErrorGenerated = data.error_generated;

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
