<template>
    <div v-bind:class="{'whole-grid-columns': inColumns, 'whole-grid-lines': !inColumns }">
        <!-- Scan -->
        <div class="column-box" v-if="this.$store.state.splitVisibility.scan">
            <window-buttons
                @popout="setWindow('scan')"
                @close="setColumn('scan')">
            </window-buttons>
            <scan-window
                :letter="letter" :zoom-key="zoomKey">
            </scan-window>
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
        <!-- Problem: image is not shown in the new Window -->
        <new-window :open="open.scan" @close="setColumn('scan')">
            <scan-window
                :letter="letter" :zoom-key="zoomKey">
            </scan-window>
        </new-window>

        <new-window :open="open.text" @close="setColumn('text')">
            <text-window
                :letter="letter">
            </text-window>
        </new-window>

    </div>

</template>

<script>
import SplitColumn from "./SplitColumn";
import LetterText from "../LetterText";
import ScanWindow from "./scans/ScanWindow";
import TextWindow from "./text/TextWindow";
import WindowButtons from "../buttons/WindowButtons";
import WindowPortal from "../../../components/ui/windows/WindowPortal";
import NewWindow from "../../../components/ui/windows/NewWindow";

export default {
    name: "WindowContainer",

    props: {
        letter: Object,
        open: Object,
    },

    data() {
        return {
            active: 1,
            inColumns: true,
            zoomKey: 0,
            scanWindow: null,
        };
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

    },

    methods: {
        setColumn(variant) {
            this.$store.dispatch({
                type: 'changeVisibility',
                payload: variant,
            });
            this.forceRender();
        },

        setWindow(type) {
            this.open[type] = !this.open[type];
            this.setColumn(type);
            // nicht richtig beim closen, zu spät, bei reload oder neudrücken macht er es (verspätet).
            console.log('setWindow container', this.open[type], type);
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
        ScanWindow,
        TextWindow,
        LetterText,
        WindowPortal,
        SplitColumn,
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
    /*border: #808080;*/
    box-shadow: -10px 0px 13px -7px #000000;
}

.scroll-box {
    overflow-x: auto;
    overflow-y: auto;
}

</style>