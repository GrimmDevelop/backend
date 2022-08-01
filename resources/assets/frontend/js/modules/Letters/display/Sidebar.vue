<template>
    <div class="sidebar overflow-auto bg-white text-gray-700 px-2 py-4 flex flex-col"
         :class="sideBarOpen ? 'open' : ''">
        <div class="sidebar-link" @click="mutateSidebar()">
            <icon :icon="sideBarOpen ? 'cheveron-right' : 'cheveron-left'"></icon>
            <span class="caption">Seitenleiste ausblenden</span>
        </div>
        <div class="sidebar-link-inactive">
            <icon icon="add-document"></icon>
            <span class="caption">Apparate zum Text (in Vorbereitung)</span>
<!--            <span class="caption">Apparate zum Text</span>-->
        </div>

        <div class="sidebar-link"
             :class="{ 'bg-gray-100': visibility(`${namespace}-scan`) }" @click="toggleColumn(`${namespace}-scan`)">
            <icon icon="letter-manuscript"></icon>
            <span class="caption">Handschrift(en)</span>
        </div>
        <div :class="{ 'bg-gray-100': visibility(`${namespace}-text`), 'sidebar-link': letter.text, 'sidebar-link-inactive': !letter.text }"
             @click="toggleColumn(`${namespace}-text`)">
            <icon icon="check-list-document"></icon>
            <span v-if="letter.text" class="caption">Text</span>
            <span v-else class="caption">Text (in Vorbereitung)</span>
        </div>

        <div class="sidebar-link-inactive">
            <icon icon="answers" color="gray-400"></icon>
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

        <div v-if="sideBarOpen" class="sidebar-information text-sm">
            <div class="sidebar-information sidebar-information-caption">Briefinformationen:</div>
            <div>Datum: {{ letter.date }}</div>
            <div>Von <span class="underline">{{ letterSender(letter.senders) }}</span></div>
            <div>An <span class="underline">{{ letterRecipient(letter.receivers) }}</span></div>
            <div class="sidebar-information-text">BriefID: {{ letter.id }}</div>
            <div class="sidebar-information-caption pt-4 clear-both float-left">
                <a href="/impressum">Impressum</a>
            </div>
        </div>
        <div v-else>
            <div class="text-xs">ID: {{ letter.id }}</div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Sidebar",

        props: {
            letter: Object,
            adminUrl: String,
            namespace: String,
        },

        computed: {
            sideBarOpen() {
                return this.$store.state.ui.sideBarOpen;
            },
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
                if (column === `${this.namespace}-text` && !this.letter.text) {
                    return;
                }
                return this.$store.commit('ui/toggle-column', {column});
            },

            visibility(column) {
                return this.$store.state.ui.visibility[column];
            },

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
        min-width: 3.5rem;
        align-items: center;
        border-left-color: $gray-400;
        margin: .1rem 0;

        &.open {
            min-width: 13rem;
            max-width: 13rem;
            align-items: flex-start;
        }
    }

    .sidebar-link, .sidebar-link-inactive {
        padding: .4rem .2rem;
        display: flex;
        align-items: center;

        .sidebar.open & {
            width: 100%;
        }

        .caption {
            display: none;
            margin-left: .25rem;

            .sidebar.open & {
                display: block;
                width: 100%;
            }
        }
    }

    .sidebar-link {
        color: $gray-700;
        cursor: pointer;
    }

    .sidebar-link-inactive{
        cursor: default;
        color: $gray-400; //gray-400 tailwind
    }

    .sidebar-link:hover, .sidebar-link-inactive:hover{
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
        align-items: center;

        .sidebar.open & {
            display: block;
            float: left;
            clear: both;
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
