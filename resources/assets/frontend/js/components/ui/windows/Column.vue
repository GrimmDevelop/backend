<template>
    <pop-out-window :name="windowName" :pop-out-url="popOutUrl">
        <slot></slot>
    </pop-out-window>
</template>

<script>
    import PopOutWindow from "@/frontend/js/components/ui/windows/PopOutWindow";

    export default {
        name: "Column",

        provide: {
            additionalButtons: [
                {
                    icon: 'close',
                    callback: () => {
                        console.log('clicked');
                    },
                }
            ],
        },

        props: {
            namespace: {
                required: true,
            },

            entity: {
                required: true,
            },

            name: {
                required: true,
            },

            defaultVisibility: {
                default: false,
            },
        },

        computed: {
            windowName() {
                return `window-${this.name}`;
            },

            popOutUrl() {
                return `/${this.namespace}/${this.entity.id}/${this.name}`;
            },
        },

        mounted() {
            this.$store.commit('ui/register-column', {
                column: `${this.namespace}-${this.name}`,
                defaultVisibility: this.defaultVisibility
            });
        },

        components: {
            PopOutWindow
        },
    };
</script>
