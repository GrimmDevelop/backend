<template>
    <div class="sidebar bg-blue-800 text-white px-2 py-4 flex flex-col"
         :class="sidebarOpen ? 'open' : ''">
        <div class="sidebar-link hover:bg-blue-900" :class="linkClass(open.text)"
             @click="textOpen">
            <icon icon="document"></icon>
            <span class="caption">Brieftext - Fenster</span>
        </div>
        <div class="sidebar-link-desc">
            {{ letter.inc }}
        </div>
        <div class="sidebar-link hover:bg-blue-900">
            <icon icon="library"></icon>
            <span class="caption">Apparate zum Text</span>
        </div>

        <div class="sidebar-link hover:bg-blue-900" v-bind:class="{ 'bg-blue-900': this.$store.state.splitVisibility.scan }" @click="setColumn('scan')">
            <icon icon="camera"></icon>
            <span class="caption">Handschrift(en)</span>
            <input class="check-box" type="checkbox" v-model="this.$store.state.splitVisibility.scan">
        </div>
        <div class="sidebar-link hover:bg-blue-900" v-bind:class="{ 'bg-blue-900': this.$store.state.splitVisibility.text }" @click="setColumn('text')">
            <icon icon="document"></icon>
            <span class="caption">Text</span>
            <input class="check-box" type="checkbox" v-model="this.$store.state.splitVisibility.text">
        </div>

        <div class="sidebar-link hover:bg-blue-900">
            <icon icon="light-bulb"></icon>
            <span class="caption">Sachkommentare</span>
        </div>

        <div class="sidebar-link hover:bg-blue-900" @click="mutateSidebar()">
            <icon :icon="sidebarOpen ? 'cheveron-right' : 'cheveron-left'"></icon>
            <span class="caption">einklappen</span>
        </div>

        <!--   is comming soon   -->
        <!--        <div class="sidebar-link hover:bg-blue-900" @click="increaseID()">-->
        <!--            <icon icon="layers"></icon>-->
        <!--            <span class="caption">nächster Brief</span>-->
        <!--        </div>-->
        <!--        <div class="sidebar-link hover:bg-blue-900" @click="decreaseID()">-->
        <!--            <icon icon="layers"></icon>-->
        <!--            <span class="caption">verheriger Brief</span>-->
        <!--        </div>-->

        <div class="flex-grow"></div>

        <div class="column-configuration">
            <span class="caption">Anzeige:</span>
            <a class="sidebar-link hover:bg-blue-900" @click="changeFormation('columns')">
                <icon icon="view-column"></icon>
                <span class="caption">Spaltenweise</span>
            </a>
            <a class="sidebar-link hover:bg-blue-900" @click="changeFormation('lines')">
                <icon icon="view-list"></icon>
                <span class="caption">Zeilenweise</span>
            </a>
        </div>

        <a :href="adminUrl" class="sidebar-link hover:bg-blue-900">
            <icon icon="layers"></icon>
            <span class="caption">Verwaltung</span>
        </a>

    </div>
</template>

<script>
export default {
    name: "Sidebar",

    props: {
        open: Object,
        sidebarOpen: Boolean,
        letter: Object,
        adminUrl: String,
    },

    methods: {
        setColumn(type) {
            this.$root.$emit('set-column', type)
            console.log("in sidebar", type)
        },

        textOpen() {
            this.$root.$emit('text-open')
        },

        increaseID() {
            this.$root.$emit('increase-id')
            console.log('increase letter')
        },

        decreaseID() {
            this.$root.$emit('decrease-id')
            console.log('decrease letter')
        },

        linkClass(isOpen) {
            return {
                'open': isOpen
            };
        },

        mutateSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        changeFormation(type) {
            console.log('changing the formation to: ', type);
            this.$root.$emit('toggle-formation', type);
        },

        getScanVisibility() {
            return this.$store.getters.getVisibilityScan;
        },
        getTextVisibility() {
            return this.$store.getters.getVisibilityText;
        },
        getMetaVisibility() {
            return this.$store.getters.getVisibilityMeta;
        },


    },
}
</script>

<style scoped lang="scss">
@import "../../../../../sass/variables";

.check-box {
    margin: .75rem;
}

.column-configuration {
    margin-block: auto;
}

.column-configuration > a{
    margin-left: 1rem;
    margin-top: 1px;
}

.sidebar {
    /*width: 4rem;*/
    align-items: center;

    &.open {
        min-width: 13rem;
        align-items: flex-start;
    }
}

.sidebar-link {
    margin: .1rem 0;
    padding: .4rem .2rem;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;

    .sidebar.open & {
        width: 100%;
    }

    .caption {
        display: none;
        margin-left: .25rem;
        line-height: 0;
        flex-grow: 1;

        .sidebar.open & {
            display: block;
            width: 100%;
        }
    }

    &.open::after {
        content: '•';
        margin-left: .25rem;
        font-size: 18pt;
        line-height: 0;
        color: $red;
    }
}

.sidebar-link-desc {
    display: none;
    color: rgba(255, 255, 255, .5);

    .sidebar.open & {
        display: block;
        width: 100%;
    }
}

</style>