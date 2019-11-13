<template>
    <div v-if="full_text">
        <h3>Brieftext</h3>

        <html-editor v-model="full_text.entry" height="250px"></html-editor>
    </div>
</template>

<script>
    import HtmlEditor from "../components/HtmlEditor";

    export default {
        name: "FullTextIndex",

        props: {
            letterId: {
                required: true,
            },
        },

        data() {
            return {
                full_text: null,
            };
        },

        mounted() {
            this.loadFullText();
        },

        methods: {
            loadFullText() {
                this.$http.get(`/api/letters/${this.letterId}/full_text`).then((response) => {
                    this.full_text = response.data.data;
                });
            },

            save() {
                this.$http.put(`/api/letters/${this.letterId}/full_text/${this.full_text.id}`, {
                    entry: this.full_text.entry,
                }).then(() => this.loadFullText());
            }
        },


        components: {
            HtmlEditor
        },
    };
</script>