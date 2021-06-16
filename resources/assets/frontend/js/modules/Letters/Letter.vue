<template>
    <div class="flex w-full h-screen" v-if="letter">
        <!--<window-container :letter="letter"></window-container>-->
        <pop-out-window name="scan" pop-out-url="/letters/715/scan">
            <scan-column :letter="letter"></scan-column>
        </pop-out-window>

        <sidebar v-if="sidebarOpen" :letter="letter" :open="$store.state.open" :sidebar-open="sidebarOpen"
                 :admin-url="adminUrl"></sidebar>
    </div>
</template>

<script>
    import WindowContainer from "./display/WindowContainer";
    import Sidebar from "./display/Sidebar";
    import PopOutWindow from "@/frontend/js/components/ui/windows/PopOutWindow";
    import ZoomImage from "@/frontend/js/components/ui/Image/ZoomImage";
    import ScanColumn from "@/frontend/js/modules/Letters/display/scans/ScanColumn";

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
                        .then(response => this.letter = response.data.data);
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
                /*this.$http.get(`data/letters/${id}`)
                    .then((response) => this.letter = response.data.data);*/
                this.$router.push({
                    name: 'letter-list',
                    params: {
                        id
                    }
                });
                // window.location.href = `#/letters/${id}`;
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
            ScanColumn,
            ZoomImage,
            PopOutWindow,
            WindowContainer,
            Sidebar,
        },
    };
</script>