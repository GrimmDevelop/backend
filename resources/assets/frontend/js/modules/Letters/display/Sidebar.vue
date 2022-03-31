<template>
    <div class="sidebar overflow-auto bg-white text-gray-700 px-2 py-4 flex flex-col"
         :class="sideBarOpen ? 'open' : ''">
        <div class="sidebar-link" @click="mutateSidebar()">
            <icon :icon="sideBarOpen ? 'cheveron-right' : 'cheveron-left'"></icon>
            <span class="caption">Seitenleiste ausblenden</span>
        </div>
        <div class="sidebar-link-inactive">
            <icon icon="library"></icon>
            <span class="caption">Apparate zum Text (in Vorbereitung)</span>
<!--            <span class="caption">Apparate zum Text</span>-->
        </div>

        <div class="sidebar-link"
             :class="{ 'bg-gray-200': visibility('letters-scan') }" @click="toggleColumn('letters-scan')">
            <icon icon="camera"></icon>
            <span class="caption">Handschrift(en)</span>
        </div>
        <div :class="{ 'bg-gray-200': visibility('letters-text'), 'sidebar-link': letter.text, 'sidebar-link-inactive': !letter.text }"
             @click="toggleColumn('letters-text')">
            <icon icon="document"></icon>
            <span v-if="letter.text" class="caption">Text</span>
            <span v-else class="caption">Text (in Vorbereitung)</span>
        </div>

        <div class="sidebar-link-inactive">
            <icon icon="light-bulb"></icon>
            <span class="caption">Sachkommentare (in Vorbereitung)</span>
<!--            <span class="caption">Sachkommentare</span>-->
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

        <div v-if="sideBarOpen" class="sidebar-information">
            <div class="sidebar-information sidebar-information-caption">Briefinformationen:</div>
            <div>Datum: {{ letter.date }}</div>
            <span class="sidebar-information-text">Von: <span class="underline">{{ letterSender(letter.senders) }}</span> an <span class="underline">{{ letterRecipient(letter.receivers) }}</span></span>
            <div>BriefID: {{ letter.id }}</div>
        </div>
        <div v-else>
            <div class="text-xs">BriefID: {{ letter.id }}</div>
        </div>

<!--        Its broken-->
<!--        <div class="column-configuration">-->
<!--            <span class="caption">Anzeige:</span>-->
<!--            <a class="sidebar-link" @click="changeFlow('columns')">-->
<!--                <icon icon="view-column"></icon>-->
<!--                <span class="caption">Spaltenweise</span>-->
<!--            </a>-->
<!--            <a class="sidebar-link" @click="changeFlow('rows')">-->
<!--                <icon icon="view-list"></icon>-->
<!--                <span class="caption">Untereinander</span>-->
<!--            </a>-->
<!--        </div>-->

        <a :href="adminUrl" class="sidebar-link">
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

            // copy from SearchResult.vue for letter information
            letterSender(sender) {
                if (sender.data.length > 0) {
                    return sender.data.map(person => person.name).join('; ');
                } else {
                    return "Unbekannt";
                }
            },

            letterRecipient(recipient) {
                if (recipient.data.length > 0) {
                    return recipient.data.map(person => person.name).join('; ');
                } else {
                    return "Unbekannt";
                }
            },
        },
    };
</script>

<style scoped lang="scss">
    @import "resources/assets/frontend/sass/_variables.scss";

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
        border-left-color: $gray-400;

        &.open {
            min-width: 13rem;
            align-items: flex-start;
        }
    }

    .sidebar-link {
        margin: .1rem 0;
        padding: .4rem .2rem;
        color: $gray-700;
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

    .sidebar-link:hover{
        background-color: $gray-200; //gray-200 tailwind
    }

    .sidebar-link-inactive{
        cursor: default;
        color: $gray-400; //gray-400 tailwind
        margin: .1rem 0;
        padding: .4rem .2rem;
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
    }

    .sidebar-link-inactive:hover{
        background-color: $gray-200; //gray-200 tailwind
    }

    .sidebar-link-desc {
        display: none;
        color: $gray-800;

        .sidebar.open & {
            display: block;
            width: 100%;
        }
    }

    .sidebar-information {
        display: none;
        padding: .4rem .2rem;
        color: $gray-700;

        .sidebar.open & {
            display: block;
            width: 15rem;
            float: left; clear: both;
        }
    }

    .sidebar-information > * {
        margin-left: 1rem;
    }

    .sidebar-information-text {
        float: left;
        clear: both;
    }

    .sidebar-information-caption {
        display: table;
        margin: 0 auto;
        font-size: large;
    }

</style>