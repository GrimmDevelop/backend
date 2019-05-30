<template>
    <div v-if="apparatus">
        <h3>Apparat</h3>

        <html-editor v-model="apparatus.entry" height="250px"></html-editor>
    </div>
</template>

<script>
    import HtmlEditor from "../components/HtmlEditor";

    export default {
        name: "ApparatusesIndex",

        data() {
            return {
                apparatus: null,
            };
        },

        props: {
            letterId: {
                required: true,
            },
        },

        mounted() {
            this.loadApparatus();
        },

        methods: {
            loadApparatus() {
                return this.$http.get(`/api/letters/${this.letterId}/apparatuses`).then((response) => {
                    this.apparatus = response.data.data;
                });
            },

            save() {
                this.$http.put(`/api/letters/${this.letterId}/apparatuses/${this.apparatus.id}`, {
                    entry: this.apparatus.entry,
                }).then(() => this.loadApparatus());
            },
        },

        components: {
            HtmlEditor
        }
    };
</script>