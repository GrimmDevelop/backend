<template>
    <div class="relative overflow-auto" v-if="!windowsIsPoppedOut">
        <div class="absolute top-4 right-4 z-10 bg-gray-300 rounded cursor-pointer grid-cols-2">
            <div class="button-toolbar tooltip" @click="popOut">
                <span class="tooltiptext">Popout</span>
                <icon icon="share"></icon>
            </div>
            <div class="button-toolbar tooltip"
                 v-for="(button, index) in windowButtons" :key="`w-button-${index}`"
                 :icon="button.icon" @click="button.callback">
                <span class="tooltiptext">Schließen</span>
                <icon icon="close"></icon>
            </div>
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

<style scoped lang="scss">
    @import "~@/sass/variables";

    .button-toolbar{
        padding-left: 12px;
        padding-right: 12px;
        padding-bottom: 10px;
        padding-top: 11px;
        display: block;
        cursor: pointer;
        user-select: none;
        border-radius: 5px;
    }

    .button-toolbar:hover{
        background: $gray-350;
    }

    .tooltip{
        position: relative;
    }
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text */
        position: absolute;
        z-index: 1;
        top: +5px;
        right: 105%;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

</style>