<template>
    <div class="flex w-full h-screen" v-if="letter">
        <div class="flex-grow grid" :class="gridClass">
            <column namespace="letters" :entity="letter" name="scan">
                <scan-column :letter="letter"/>
            </column>

            <column namespace="letters" :entity="letter" name="text">
                <letter-text :text="letter.text" class="p-4"/>
            </column>
        </div>

        <sidebar :letter="letter"
                 @increase-id="$router.push({name: 'letters-view', params: {id: parseInt(letter.id) + 1}})"
                 @decrease-id="$router.push({name: 'letters-view', params: {id: parseInt(letter.id) - 1}})"
                 :admin-url="adminUrl"></sidebar>
    </div>
</template>

<script>
    import Sidebar from "./display/Sidebar";
    import ScanColumn from "@/frontend/js/modules/Letters/display/scans/ScanColumn";
    import LetterText from "@/frontend/js/modules/Letters/LetterText";
    import Column from "@/frontend/js/components/ui/windows/Column";

    export default {
        name: "Letter",

        data() {
            return {
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

            gridClass() {
                return {
                    'grid-flow-col': true,
                    'grid-cols-auto': true,

                    'grid-flow-row': false,
                    'grid-rows-auto': false,
                };
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
            this.$on('changing-letter', (id) => {
                this.$router.push({
                    name: 'letter-list',
                    params: {
                        id
                    }
                });
            });
        },

        components: {
            Column,
            LetterText,
            ScanColumn,
            Sidebar,
        },
    };
</script>

<style>
    .grid-cols-auto {
        grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
    }

    .grid-rows-auto {
        grid-template-rows: repeat(auto-fit, minmax(0, 1fr));
    }
</style>