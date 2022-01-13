<template>
    <div class="relative overflow-auto" v-if="!windowsIsPoppedOut">
        <div class="absolute top-4 right-4 z-10 bg-gray-300 rounded p-3 cursor-pointer">
            <icon icon="share" @click="popOut"></icon>

            <icon v-for="(button, index) in windowButtons" :key="`w-button-${index}`"
                  :icon="button.icon" @click="button.callback"></icon>
        </div>

        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "PopOutWindow",

        inject: {
            additionalButtons: {
                default: () => ([]),
            },
        },

        data() {
            return {
                windowHandle: null,
                windowsIsPoppedOut: false,
                checkWindowsState: null,
            };
        },

        props: {
            name: {},
            popOutUrl: {}
        },

        computed: {
            windowButtons() {
                return this.additionalButtons;
            },
        },

        watch: {
            popOutUrl() {
                if (this.windowsIsPoppedOut) {
                    this.windowHandle = window.open(this.popOutUrl, this.name, "top=0,left=0");
                    this.windowHandle.blur();
                    self.focus();
                }
            },
        },

        methods: {
            popOut() {
                this.windowsIsPoppedOut = true;
                this.windowHandle = window.open(this.popOutUrl, this.name, "top=0,left=0");
                this.startWindowCheck();
            },

            startWindowCheck() {
                this.checkWindowsState = setInterval(() => {
                    if (this.windowHandle && this.windowHandle.closed) {
                        clearInterval(this.checkWindowsState);
                        this.windowsIsPoppedOut = false;
                    }
                }, 1000);
            },
        },

        mounted() {
            /*this.windowHandle = window.open("", this.name, "top=0,left=0");
            if (this.windowHandle.location.href === "about:blank") {
                this.windowsIsPoppedOut = false;
                this.windowHandle.blur();
                self.focus();
                this.windowHandle.close();
            } else {
                this.windowsIsPoppedOut = true;
                this.startWindowCheck();
            }*/
        }
    };
</script>

<style scoped>

</style>