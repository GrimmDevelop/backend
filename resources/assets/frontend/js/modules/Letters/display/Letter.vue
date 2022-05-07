<template>
    <div class="flex h-screen bg-gray-200" v-if="letter">
        <div class="flex-grow grid gap-2 p-4" :class="gridClass" ref="columnContainer">
            <column namespace="letters" :entity="letter" name="scan">
                <scan-column :letter="letter"/>
            </column>

            <column namespace="letters" :entity="letter" name="text" :default-visibility="showLetterText">
                <text-column :text="letter.text" class="p-4"/>
            </column>
        </div>

        <sidebar :letter="letter"
                 @increase-id="$router.push({name: 'letters-view', params: {id: parseInt(letter.id) + 1}})"
                 @decrease-id="$router.push({name: 'letters-view', params: {id: parseInt(letter.id) - 1}})"
                 :admin-url="adminUrl"
                 namespace="letters"></sidebar>
    </div>
</template>

<script>
    import Sidebar from "./Sidebar";
    import ScanColumn from "./ScanColumn";
    import TextColumn from "./TextColumn";
    import Column from "../../../components/ui/windows/Column.vue";

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

            showLetterText() {
                return Boolean(this.letter.text);
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

        components: {
            Column,
            TextColumn,
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