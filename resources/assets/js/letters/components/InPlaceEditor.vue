<template>
    <tr v-if="existing">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><span class="fa fa-times"></span></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control form-control-sm" v-model="editingEntry" ref="entryInput"
                   v-on:keyup.enter="saveItem()"/>
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><span class="fa fa-edit"></span></a> {{ entry }}
        </td>
        <td v-if="editing">
            <input type="text" class="form-control form-control-sm" v-model="editingYear"
                   v-on:keyup.enter="saveItem()"/>
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveItem()">
                <span class="fa fa-spinner fa-spin" v-if="saving"></span> Speichern
            </button>
        </td>
        <td colspan="2" v-if="!editing">
            {{ year }}
            <a href="#" v-on:click.prevent="deleteItem" v-if="editable">
                <span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Löschen"></span>
            </a>
        </td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['itemId', 'itemEntry', 'itemYear', 'baseUrl', 'editable'],

        data() {
            return {
                editing: false,
                existing: true,
                saving: false,
                entry: '',
                year: '',
                editingEntry: '',
                editingYear: ''
            };
        },

        mounted() {
            this.entry = this.itemEntry;
            this.year = this.itemYear;
        },

        methods: {
            clickEdit() {
                if (this.editingYear === '') {
                    this.editingYear = this.year;
                }
                if (this.editingEntry === '') {
                    this.editingEntry = this.entry;
                }
                this.editing = true;
                this.focusEntryInput();
            },

            stopEdit() {
                this.editing = false;
            },

            saveItem() {
                this.saving = true;
                this.$http.put(this.baseUrl + '/' + this.itemId, {
                    entry: this.editingEntry,
                    year: this.editingYear
                }).then(({data}) => {
                    this.entry = data.entry;
                    this.year = data.year;
                    this.editing = false;
                    this.saving = false;
                });
            },

            deleteItem() {
                if (window.confirm("Soll der Eintrag wirklich gelöscht werden?")) {
                    this.$http.delete(this.baseUrl + '/' + this.itemId).then(() => {
                        this.existing = false;
                    });
                }
            },

            focusEntryInput() {
                Vue.nextTick((function () {
                    this.$refs.entryInput.focus();
                }).bind(this));
            }
        }
    };
</script>
