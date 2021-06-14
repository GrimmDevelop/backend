<template>
    <div class="flex w-full h-screen">
        <template v-if="letter">
            <window-container :letter="letter"></window-container>

            <sidebar v-if="sidebarOpen" :letter="letter" :open="this.$store.state.open" :sidebar-open="sidebarOpen"
                     :admin-url="adminUrl"></sidebar>
        </template>
    </div>
</template>

<script>
    import WindowContainer from "./display/WindowContainer";
    import Sidebar from "./display/Sidebar";

    export default {
        name: "Letter",

        data() {
            return {
                sidebarOpen: true,
                letter: null,
            };
        },

        computed: {
            id() {
                return this.$route.params.id;
            },

            adminUrl() {
                return window.Laravel.adminUrl;
            },
        },

        watch: {
            id: {
                immediate: true,
                handler() {
                    this.$http.get(`/data/letters/${this.id}`)
                        .then((response) => {
                            this.letter = response.data.data;
                            console.log(response);
                        });
                },
            },
        },

        mounted() {
            this.$root.$on('increase-id', () => {
                let nID = parseInt(this.id) + 1;
                console.log('I have to change the ID to: ', nID);
                this.changedLetter(nID);
            });
            this.$root.$on('decrease-id', () => {
                let nID = parseInt(this.id) - 1;
                console.log('I have to change the ID to: ', nID);
                this.changedLetter(nID);
            });
            this.$root.$on('opened-window', () => {
                console.log("I am in Letter.vue and got the info, that the window is opened.");
                this.openedWindow();
            });
            this.$root.$on('changing-letter', (id) => {
                // still to be adjusted (setting of letterID)
                this.$http.get(`data/letters/${id}`)
                    .then((response) => {
                        this.letter = response.data.data;
                        console.log("I am in Letter.vue ", response);
                    });
                window.location.href = `#/letters/${id}`;
            });
        },

        methods: {
            changedLetter(id) {
                console.log('I am in Letter.vue and I sent this id: ', id);
                this.$http.post('/updateLetter', {letterId: id});
            },

            openedWindow() {
                console.log("sent that the window is open");
                this.$http.post('/openWindow');
            },

        },

        components: {
            WindowContainer,
            Sidebar,
        },
    };
</script>