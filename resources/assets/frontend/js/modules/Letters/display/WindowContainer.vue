<template>
    <div class="window-grid" :class="{'use-columns': inColumns, 'use-lines': !inColumns }">
        <!-- Scan -->
        <div class="column-box" v-if="$store.state.splitVisibility.scan">
            <window-buttons
                @popout="setWindow('scan')"
                @close="setColumn('scan')">
            </window-buttons>
            <scan-column ref="scanColumn" :letter="letter"></scan-column>
        </div>
        <!-- Letter Text -->
        <div class="column-box scroll-box" v-if="$store.state.splitVisibility.text">
            <window-buttons
                @popout="setWindow('text')"
                @close="setColumn('text')">
            </window-buttons>
            <text-window
                :letter="letter">
            </text-window>
        </div>
        <new-window :letter="letter" :open="$store.state.open.scan" @opened="openedWindow"
                    @close="setWindow('scan')">
            <scan-column ref="scanColumnWindow" :letter="letter"></scan-column>
        </new-window>
        <new-window :open="$store.state.open.text" @opened="openedWindow" @close="setWindow('text')">
            <text-window :letter="letter"></text-window>
        </new-window>
    </div>
</template>

<script>
    import ScanColumn from "./scans/ScanColumn";
    import TextWindow from "./text/TextWindow";
    import WindowButtons from "../buttons/WindowButtons";
    import NewWindow from "../../../components/ui/windows/NewWindow";

    export default {
        name: "WindowContainer",

        props: {
            letter: Object,
        },

        data() {
            return {
                active: 1,
                inColumns: true,
            };
        },

        computed: {
            imageUrl() {
                return this.letter.scans[this.active - 1].url;
            },

            hasImages() {
                return this.scanCount > 0;
            },
        },

        created() {
            window.Echo.channel('update-letter').listen('ChangedLetter', e => {
                this.$root.$emit('changing-letter', e.letterId.letterId);
            });

            window.Echo.channel('opened-window').listen('OpenedWindow', () => {
                console.log("The window is open and I will center the image");
                this.recenterScan();
            });
        },

        mounted() {
            this.$root.$on('text-open', () => {
                this.setWindow('text');
            });

            this.$root.$on('set-column', (type) => {
                this.setColumn(type);
            });

            this.$root.$on('toggle-formation', (type) => {
                this.toggleFormation(type);
            });

            this.$root.$on('mutate-sidebar', () => {
                this.mutatedSidebar();
            });

        },

        methods: {
            setColumn(variant) {
                this.$store.dispatch({
                    type: 'changeVisibility',
                    payload: variant,
                });
                this.recenterScan();
            },

            setWindow(variant) {
                this.setColumn(variant);
                this.$store.dispatch({
                    type: 'changeOpen',
                    payload: variant,
                });
            },

            toggleFormation(type) {
                if (type === 'columns') {
                    this.inColumns = true;
                } else if (type === 'lines') {
                    this.inColumns = false;
                } else {
                    console.log('An error occurred while the toggle Formation');
                }
                this.recenterScan();
            },

            recenterScan() {
                console.log("resetting scan position");
                if (this.$refs.scanColumn) {
                    this.$refs.scanColumn.resetImagePosition();
                }
                if (this.$refs.scanColumnWindow) {
                    this.$refs.scanColumnWindow.resetImagePosition();
                }
            },

            openedWindow() {
                console.log("I am in the WindowContainer and the window opened");
                this.$root.$emit('opened-window');
            },

            mutatedSidebar() {
                this.recenterScan();
            },
        },

        components: {
            ScanColumn,
            TextWindow,
            WindowButtons,
            NewWindow,
        },
    };
</script>

<style scoped>

    .window-grid {
        padding: 0.1rem;
        display: grid;
        position: relative;
        width: 100vw;
        height: 100vh;
    }

    .use-columns {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    }

    .use-lines {
        grid-template-rows: repeat(auto-fit, minmax(100px, 1fr));
    }

    .column-box {
        display: grid;
        position: relative;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        border-radius: 5px;
        box-shadow: -10px 0 13px -7px #000000;
    }

    .scroll-box {
        overflow-x: auto;
        overflow-y: auto;
    }

</style>