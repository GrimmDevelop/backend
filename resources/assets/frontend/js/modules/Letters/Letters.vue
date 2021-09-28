<template>
    <div>
        <search-form />
    </div>
</template>

<script>
    import SearchForm from "../../components/ui/search/SearchForm";
    export default {
        name: "Letters",
        components: {SearchForm},
        data() {
            return {
                letters: [],
            };
        },

        mounted() {
            //this.$http.get('/data/letters')
            //    .then(response => this.letters = response.data.data);
        },
    };
</script>

<style scoped>

</style>