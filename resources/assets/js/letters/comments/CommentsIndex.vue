<template>
    <div v-if="comment">
        <h3>Sachkommentar</h3>

        <html-editor v-model="comment.entry" height="250px"></html-editor>
    </div>
</template>

<script>
    import HtmlEditor from "@/js/letters/components/HtmlEditor";

    export default {
        name: "CommentsIndex",

        props: {
            letterId: {
                required: true,
            },
        },

        data() {
            return {
                comment: null,
            };
        },

        mounted() {
            this.loadComment();
        },

        methods: {
            loadComment() {
                this.$http.get(`/api/letters/${this.letterId}/comments`).then((response) => {
                    this.comment = response.data.data;
                });
            },

            save() {
                this.$http.put(`/api/letters/${this.letterId}/comments/${this.comment.id}`, {
                    entry: this.comment.entry,
                }).then(() => this.loadComment());
            }
        },


        components: {
            HtmlEditor
        },
    };
</script>