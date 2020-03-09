<template>
    <div v-if="open" v-show="loaded">
        <slot/>
    </div>
</template>

<script>
    export default {
        name: "WindowPortal",

        props: {
            open: {
                type: Boolean,
                default: false,
            },
            width: {
                type: Number,
                default: 800,
            },
            height: {
                type: Number,
                default: 600,
            },
            top: {
                type: Number,
                default: 200,
            },
            left: {
                type: Number,
                default: 200,
            },
            menubar: {
                type: Boolean,
                default: false,
            },
            status: {
                type: Boolean,
                default: false,
            },
            location: {
                type: Boolean,
                default: false,
            },
            noStyle: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                childWindow: null,
                loaded: false,
            };
        },

        watch: {
            open() {
                if (this.open) {
                    this.openWindow();
                } else {
                    this.closeWindow();
                }
            }
        },

        methods: {
            openWindow() {
                if (this.childWindow) {
                    return;
                }

                this.childWindow = window.open(
                    window.location.origin + '/loader',
                    "",
                    `width=${this.width},height=${this.height},left=${this.left},top=${this.top},menubar=${this.menubar},status=${this.status},location=${this.location}`
                );

                this.childWindow.addEventListener('beforeunload', this.closeWindow);

                this.childWindow.addEventListener('load', () => {
                    // Clear any existing content
                    this.childWindow.document.body.innerHTML = '';
                    this.childWindow.document.title = document.title;

                    // Move the component into the window
                    const app = document.createElement('div');

                    app.id = 'app';
                    app.appendChild(this.$el);

                    this.childWindow.document.body.appendChild(app);
                    this.$emit('update:open', true);
                    this.$emit('opened', this.childWindow);

                    // Clone style nodes
                    if (!this.noStyle) {
                        for (const el of document.head.querySelectorAll('style, link[rel=stylesheet]')) {
                            const clone = el.cloneNode(true);
                            this.childWindow.document.head.appendChild(clone);
                        }
                    }

                    this.loaded = true;
                });
            },

            closeWindow() {
                if (this.childWindow) {
                    this.loaded = false;
                    this.childWindow.close();
                    this.childWindow = null;
                    this.$emit('update:open', false);
                    this.$emit('closed');
                }
            }
        },

        mounted() {
            if (this.open) {
                this.openWindow();
            }

            window.addEventListener('beforeunload', this.closeWindow);
        },

        beforeDestroy() {
            if (this.childWindow) {
                this.closeWindow();
            }

            window.removeEventListener('beforeunload', this.closeWindow);
        },
    };
</script>

<style scoped>

</style>
