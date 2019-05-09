<template>
    <div>
        <textarea ref="editor" :value="value"></textarea>
    </div>
</template>

<script>
    import tinymce from 'tinymce/tinymce';
    import 'tinymce/themes/modern/theme';

    import 'tinymce/plugins/paste/plugin';
    import 'tinymce/plugins/code/plugin';

    export default {
        name: "HtmlEditor",

        data() {
            return {
                toolbar: 'bold italic strikethrough underline subscript superscript | alignleft aligncenter alignright alignjustify | code',
                instance: null,
            };
        },

        props: {
            value: {
                default: "",
            },
            height: {
                default: null,
            }
        },

        watch: {
            value(content) {
                if (this.instance !== null && content !== this.instance.getContent()) {
                    this.instance.setContent(content);
                }
            }
        },

        mounted() {
            let that = this;
            tinymce.init({
                target: this.$refs.editor,
                branding: false,
                menubar: false,
                height: this.height,
                skin: false,
                plugins: ['paste', 'code'],
                toolbar: this.toolbar,
                content_css: "/css/formats.css",
                setup(editor) {
                    editor.on('Change', () => {
                        that.$emit('input', editor.getContent());
                    });
                }
            }).then(([editor]) => {
                this.instance = editor;
            });
        }
    };
</script>

<style scoped>

</style>