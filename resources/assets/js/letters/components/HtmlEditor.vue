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

        mounted() {
            tinymce.init({
                target: this.$refs.editor,
                branding: false,
                menubar: false,
                height: this.height,
                skin: false,
                plugins: ['paste', 'code'],
                toolbar: this.toolbar,
                content_css : "/css/formats.css",
                init_instance_callback: (editor) => {
                    editor.on('Change', () => {
                        this.$emit('input', editor.getContent());
                    });
                }
            });
        }
    };
</script>

<style scoped>

</style>