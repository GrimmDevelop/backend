<template>
    <div v-if="letterText">
        <h3>Brieftext</h3>
        <div v-html="letterText.entry" style="width:138mm" />
    </div>
</template>

<script>
    export default {
        name: "LetterTextIndex",

        data() {
            return {
                letterText: null,
            };
        },

        props: {
            letterId: {
                required: true,
            },
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
        },
    };
</script>