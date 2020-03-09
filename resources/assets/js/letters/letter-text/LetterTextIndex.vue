<template>
    <div v-if="letterText">
        <h3>Brieftext</h3>
        <div v-html="letterText.entry" style="width:138mm"></div>
        <textarea v-model="letterText.entry" style="width: 100%;" rows="20"></textarea>
    </div>
</template>

<script>
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

            this.parse();
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

            parse() {
                let parser = new DOMParser();
                let xml = parser.parseFromString(this.debug, "text/xml");

                console.log(xml.childNodes[0].childNodes);
            },
        },

        components: {},
    };
</script>
