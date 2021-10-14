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
                        // How do we call the store in the callback function? The following code doesn't work.Wie soll der Store in der callback Funktion aufgerufen werden?
                        this.$store.commit('ui/toggle-column', {
                            column: 'letters-text'
                        });
                        // Alternative: call toggleColumn (method)
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
                default: true,
            },
        },

        computed: {
            windowIsShown(colName) {
                // Alternative: using getter!?
                return this.$store.state.ui.visibility[`letters-${colName}`];
            },

            windowName() {
                return `window-${this.name}`;
            },

            popOutUrl() {
                return `/${this.namespace}/${this.entity.id}/${this.name}`;
            },
        },

        method: {
            toggleColumn() {
                this.$store.commit('ui/toggle-column', {
                    column: `${this.namespace}-${this.name}`
                });
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
