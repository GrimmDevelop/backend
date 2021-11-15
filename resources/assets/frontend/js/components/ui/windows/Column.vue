<template>
    <pop-out-window :name="windowName" :pop-out-url="popOutUrl" v-if="windowIsShown">
        <slot></slot>
    </pop-out-window>
</template>

<script>
    import PopOutWindow from "@/frontend/js/components/ui/windows/PopOutWindow";

    export default {
        name: "Column",

        provide() {
            const that = this;

            return {
                additionalButtons: [
                    {
                        icon: 'close',
                        callback() {
                            that.$store.commit('ui/toggle-column', {
                                column: that.columnName,
                            });
                        },
                    }
                ],
            };
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
            windowIsShown() {
                return this.$store.getters['ui/columnVisibility'](this.columnName);
            },

            windowName() {
                return `window-${this.name}`;
            },

            columnName() {
                return `${this.namespace}-${this.name}`;
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
