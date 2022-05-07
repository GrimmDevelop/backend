<template>
    <div v-if="letterText">
        <h3>Brieftext</h3>
        <div class="row">
            <div class="col-6">
                <h5>Editor (Code-Modus)</h5>
                <textarea v-model="letterText.entry" style="width: 100%;" rows="50"></textarea>
            </div>
            <div class="col-6">
                <h5>Vorschau</h5>
                <text-column :text="letterText.entry"></text-column>
            </div>
        </div>
    </div>
</template>

<script>
    import TextColumn from "../../../frontend/js/modules/Letters/display/TextColumn";

    export default {
        name: "LetterTextIndex",

        data() {
            return {
                letterText: null,
                document: null,

                debug: "<document><page><line>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</line><line>Cupiditate doloribus, eos fuga ipsam itaque maxime perferendis quo quos?</line></page><page><line>Autem corporis facere ipsum minima natus,</line><line>nesciunt non repellat repellendus totam veniam.</line></page></document>",
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
            },
        },

        components: {
            TextColumn
        },
    };
</script>
