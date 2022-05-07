<template>
    <div class="add-filter-button-area">
        <v-select class="add-filter-button" label="name" :options="options" placeholder="weiteres Suchfeld hinzufügen" v-model="selected">
        </v-select>
    </div>
</template>

<script>
    export default {
        name: "SearchAddFilterButton",

        data() {
            return {
                selected: '',
            };
        },

        props: {
            remaining_filters: {}
        },

        watch: {
            selected: function (val) {
                this.$emit('addFilter',val);
                this.selected = "";
            },
        },

        computed: {
            options() {
                return this.remaining_filters;
            }
        },
    };
</script>

<style lang="scss" scoped>
    .add-filter-button{
        width: 20rem;
        margin: 0.5rem auto 1rem auto;
    }
</style>
