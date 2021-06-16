<template>
    <div class="relative h-screen w-full overflow-auto" v-if="!windowsIsPoppedOut">
        <div class="absolute top-0 left-0 z-10 bg-gray-300 rounded p-3">
            <icon icon="share" @click="popOut"></icon>
        </div>

        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "PopOutWindow",

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

        watch: {
            popOutUrl() {
                if (this.windowsIsPoppedOut) {
                    this.windowHandle = window.open(this.popOutUrl, this.name);
                }
            }
        },

        methods: {
            popOut() {
                this.windowsIsPoppedOut = true;
                this.windowHandle = window.open(this.popOutUrl, this.name);
                this.checkWindowsState = setInterval(() => {
                    if (this.windowHandle && this.windowHandle.closed) {
                        clearInterval(this.checkWindowsState);
                        this.windowsIsPoppedOut = false;
                    }
                }, 1000);
            }
        },

        mounted() {
            // check if window was already popped out in previous session
            window.Echo.private('test').listenForWhisper('popout-window', ({name}) => {
                if (name === this.name) {
                    this.popOut();
                }
            });
        }
    };
</script>

<style scoped>

</style>