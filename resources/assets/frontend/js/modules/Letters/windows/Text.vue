<template>
    <div v-if="letter" class="h-screen">
        <text-column :text="letter.text"></text-column>
    </div>
</template>

<script>
    import TextColumn from "@/frontend/js/modules/Letters/display/TextColumn";

    export default {
        name: "Text",

        data() {
            return {
                letter: null,
            };
        },

        computed: {
            id() {
                return this.$route.params.id;
            },
        },

        watch: {
            id: {
                immediate: true,
                handler() {
                    this.$http.get(`/data/letters/${this.id}`)
                        .then(response => this.letter = response.data.data);
                },
            },
        },

        components: {
            TextColumn
        },
    };
</script>

<style scoped>

</style>