<template>
    <div>
        <h1>Letters</h1>

        <ul>
            <li v-for="letter in letters">
                <router-link :to="`letters/${letter.id}`">Letter #{{ letter.id }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Letters",

        data() {
            return {
                letters: [],
            };
        },

        mounted() {
            this.$http.get('/data/letters')
                .then(response => this.letters = response.data.data);
        },
    };
</script>

<style scoped>

</style>