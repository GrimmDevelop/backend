<template>
    <div v-if="letterText">
        <h3>Brieftext</h3>

        <html-editor v-model="letterText.entry" height="250px"></html-editor>
    </div>
</template>

<script>
    import HtmlEditor from "../components/HtmlEditor";

    export default {
        name: "LetterTextIndex",

        props: {
            letterId: {
                required: true,
            },
        },

        data() {
            return {
                letterText: null,
            };
        },

        mounted() {
            this.loadLetterText();
        },

        methods: {
            loadLetterText() {
                this.$http.get(`/api/letters/${this.letterId}/letter-text`).then((response) => {
                    this.letterText = response.data.data;
                });
            },

            save() {
                this.$http.put(`/api/letters/${this.letterId}/letter-text/${this.letterText.id}`, {
                    entry: this.letterText.entry,
                }).then(() => this.loadLetterText());
            }
        },


        components: {
            HtmlEditor
        },
    };
</script>