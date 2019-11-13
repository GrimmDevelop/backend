<template>
    <div v-if="lettertext">
        <h3>Brieftext</h3>

        <html-editor v-model="lettertext.entry" height="250px"></html-editor>
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
                full_text: null,
            };
        },

        mounted() {
            this.loadLetterText();
        },

        methods: {
            loadLetterText() {
                this.$http.get(`/api/letters/${this.letterId}/lettertext`).then((response) => {
                    this.lettertext = response.data.data;
                });
            },

            save() {
                this.$http.put(`/api/letters/${this.letterId}/lettertext/${this.full_text.id}`, {
                    entry: this.lettertext.entry,
                }).then(() => this.loadLetterText());
            }
        },


        components: {
            HtmlEditor
        },
    };
</script>