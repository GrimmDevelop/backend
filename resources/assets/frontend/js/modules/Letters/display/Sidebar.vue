<template>
    <div class="sidebar overflow-auto bg-blue-800 text-white px-2 py-4 flex flex-col"
         :class="sideBarOpen ? 'open' : ''">
        <div class="sidebar-link hover:bg-blue-900" @click="mutateSidebar()">
            <icon :icon="sideBarOpen ? 'cheveron-right' : 'cheveron-left'"></icon>
            <span class="caption">Seitenleiste ausblenden</span>
        </div>

        <div class="sidebar-link hover:bg-blue-900" :class="linkClass('letters-text')"
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

        <div class="sidebar-link hover:bg-blue-900"
             :class="{ 'bg-blue-900': visibility('letters-scan') }" @click="toggleColumn('letters-scan')">
            <icon icon="camera"></icon>
            <span class="caption">Handschrift(en)</span>
        </div>
        <div class="sidebar-link hover:bg-blue-900"
             :class="{ 'bg-blue-900': visibility('letters-text') }" @click="toggleColumn('letters-text')">
            <icon icon="document"></icon>
            <span class="caption">Text</span>
        </div>

        <div class="sidebar-link hover:bg-blue-900">
            <icon icon="light-bulb"></icon>
            <span class="caption">Sachkommentare</span>
        </div>

        <!--   will be modified for the new data structure (conversations)   -->
<!--        <div class="sidebar-link hover:bg-blue-900" @click="increaseID()">-->
<!--            <icon icon="layers"></icon>-->
<!--            <span class="caption">nächster Brief</span>-->
<!--        </div>-->
<!--        <div class="sidebar-link hover:bg-blue-900" @click="decreaseID()">-->
<!--            <icon icon="layers"></icon>-->
<!--            <span class="caption">vorheriger Brief</span>-->
<!--        </div>-->

        <div class="flex-grow"></div>

        <div class="column-configuration">
            <span class="caption">Anzeige:</span>
            <a class="sidebar-link hover:bg-blue-900" @click="changeFlow('columns')">
                <icon icon="view-column"></icon>
                <span class="caption">Spaltenweise</span>
            </a>
            <a class="sidebar-link hover:bg-blue-900" @click="changeFlow('rows')">
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
            letter: Object,
            adminUrl: String,
        },

        computed: {
            sideBarOpen() {
                return this.$store.state.ui.sideBarOpen;
            }
        },

        methods: {
            textOpen() {
                this.$store.commit('ui/toggle-column', {
                // opens the letters text instant? Intentional function?
                });
            },

            linkClass(column) {
                return {
                    'open': this.visibility(column),
                };
            },

            mutateSidebar() {
                this.$store.commit('ui/toggle-sidebar');
            },

            changeFlow(type) {
                this.$store.commit('ui/window-flow', {type});
            },

            toggleColumn(column) {
                return this.$store.commit('ui/toggle-column', {column});
            },

            visibility(column) {
                return this.$store.state.ui.visibility[column];
            },
        },
    };
</script>

<style scoped lang="scss">
    @import "~@/sass/variables";

    .check-box {
        margin: .75rem;
    }

    .column-configuration {
        margin-block: auto;
    }

    .column-configuration > a {
        margin-left: 1rem;
        margin-top: 1px;
    }

    .sidebar {
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