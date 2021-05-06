<template>
    <div class="flex w-full h-screen">
        <template v-if="letter">
            <!--   Window-Container   -->
            <window-container :letter="letter" :open="open"></window-container>

            <!--   Sidebar   -->
            <!--            soll: componente sidebar-->
            <sidebar v-if="sidebarOpen" :letter="letter" :open="open" :sidebar-open="sidebarOpen"
                     :admin-url="adminUrl"></sidebar>

        </template>
    </div>
</template>

<script>
import WindowContainer from "./display/WindowContainer";
import Sidebar from "./display/Sidebar";
import LetterText from "./LetterText";


export default {
    name: "Letter",

    data() {
        return {
            sidebarOpen: true,
            letter: null,
            open: {
                scan: false,
                text: false,
            }
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

    mounted() {
        this.$root.$on('increase-id', () => {
            let nID = parseInt(this.id) + 1;
            console.log('ich soll wohl zu einer anderen ID gehen: ', nID);
            window.location.href = `#/letters/00${nID}`;
        });
         this.$root.$on('decrease-id', () => {
            let nID = parseInt(this.id) - 1;
            console.log('ich soll wohl zu einer anderen ID gehen: ', nID);
            window.location.href = `#/letters/00${nID}`;
        });
        //  this.$root.$on('open-or-close', (type) => {
        //      this.open[type] = !this.open[type];
        // })
    },

    watch: {
        id: {
            immediate: true,
            handler() {
                this.$http.get(`data/letters/${this.id}`)
                    .then((response) => {
                        this.letter = response.data.data;
                        console.log(response);
                    });
            }
        }
    },

    components: {
        LetterText,
        WindowContainer,
        Sidebar,
    },
};
</script>

<style scoped lang="scss">

</style>
