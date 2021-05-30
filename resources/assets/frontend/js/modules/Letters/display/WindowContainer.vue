<template>
    <div v-bind:class="{'whole-grid-columns': inColumns, 'whole-grid-lines': !inColumns }">
        <!-- Scan -->
        <div class="column-box" v-if="this.$store.state.splitVisibility.scan">
            <window-buttons
                @popout="setWindow('scan')"
                @close="setColumn('scan')">
            </window-buttons>
            <scan-column
                :letter="letter" :zoom-key="zoomKey">
            </scan-column>
        </div>
        <!-- Letter Text -->
        <div class="column-box scroll-box" v-if="this.$store.state.splitVisibility.text">
            <window-buttons
                @popout="setWindow('text')"
                @close="setColumn('text')">
            </window-buttons>
            <text-window
                :letter="letter">
            </text-window>
        </div>
        <new-window :letter="letter" :open="this.$store.state.open.scan" @opened="openedWindow" @close="setWindow('scan')">
            <scan-column
                :letter="letter" :zoom-key="zoomKey">
            </scan-column>
        </new-window>
        <new-window :open="this.$store.state.open.text" @opened="openedWindow" @close="setWindow('text')">
            <text-window
                :letter="letter" :zoom-key="zoomKey">
            </text-window>
        </new-window>


    </div>

</template>

<script>
import LetterText from "../LetterText";
import ScanColumn from "./scans/ScanColumn";
import TextWindow from "./text/TextWindow";
import WindowButtons from "../buttons/WindowButtons";
import WindowPortal from "../../../components/ui/windows/WindowPortal";
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
            zoomKey: 0,
        };
    },
    created() {
        window.Echo.channel('update-letter').listen('ChangedLetter', e => {
            this.$root.$emit('changing-letter', e.letterId.letterId)
        });

        window.Echo.channel('opened-window').listen('OpenedWindow', e => {
            console.log("The window is open and I will center the image")
            this.forceRender();
        });
    },
    mounted() {
        this.$root.$on('text-open', () => {
            this.setWindow('text')
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
            this.forceRender();
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
            console.log('An error occurred while the toggle Formation');
            this.forceRender();
        },

        forceRender() {
            this.zoomKey += 1;
            console.log("I just rendered the scan!");
        },

        openedWindow() {
            console.log("I am in the WindowContainer and the window opened");
            this.$root.$emit('opened-window');
        },

        mutatedSidebar() {
            this.forceRender();
        },
    },

    computed: {
        imageUrl() {
            return this.letter.scans[this.active - 1].url;
        },

        hasImages() {
            return this.scanCount > 0;
        },

    },


    components: {
        ScanColumn,
        TextWindow,
        LetterText,
        WindowPortal,
        WindowButtons,
        NewWindow,
    },
}
</script>

<style scoped>

.whole-grid-columns {
    padding: 0.1rem;
    display: grid;
    position: relative;
    width: 100vw;
    height: 100vh;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
}

.whole-grid-lines {
    padding: 0.1rem;
    display: grid;
    position: relative;
    width: 100vw;
    height: 100vh;
    grid-template-rows: repeat(auto-fit, minmax(100px, 1fr));
}

.column-box {
    display: grid;
    position: relative;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
    border-radius: 5px;
    box-shadow: -10px 0px 13px -7px #000000;
}

.scroll-box {
    overflow-x: auto;
    overflow-y: auto;
}

</style>