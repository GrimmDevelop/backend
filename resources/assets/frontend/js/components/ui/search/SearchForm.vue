<template>
    <div class="complete-container">
        <div class="search-form">
            <simple-form v-if="mode === 'simple'" :value="searchAll" @switch-mode="mode = 'advanced'"
                         @filter="searchAll = $event" @search="startSearch"/>

            <advanced-form v-else @switch-mode="mode = 'simple'" :search="search"
                           :filters="filters"
                           @filter="updateFilter" @search="startSearch"/>
        </div>

        <search-dotted-line class="dotted-line" v-if="hasResults"></search-dotted-line>

        <search-result v-if="hasResults" :letters="letters"></search-result>

        <span @click="pagination.page++">{{ pagination.page }}</span>
    </div>
</template>

<script>
    import qs from 'qs';

    import SearchAddFilterButton from "./SearchAddFilterButton";
    import SearchDottedLine from "./SearchTheDottedLine";
    import SimpleForm from "./SimpleForm";
    import SearchSearchFilter from "./SearchSearchFilter";
    import SearchResult from "./SearchResult";
    import AdvancedForm from "./AdvancedForm";

    export default {
        name: "SearchForm",

        data() {
            return {
                mode: 'advanced',
                searchAll: "",
                search: {
                    senders: "",
                    receivers: "",
                    date: {
                        from: "",
                        to: "",
                    },
                    handwriting: "",
                    print: "",
                    sender_place: "",
                    letter_start: "",
                    letter_number: "",
                },
                pagination: {
                    page: 1,
                    limit: 25,
                },
                letters: [],
                showResults: false,
                senders: [
                    "Grimm, Wilhelm",
                    "Grimm, Jacob"
                ],
                receiver: [
                    "Grimm, Wilhelm",
                    "Grimm, Jacob"
                ],
                filters: [
                    {
                        name: "Absender",
                        id: "senders",
                        type: "select",
                    },
                    {
                        name: "Empfänger",
                        id: "receivers",
                        type: "select",
                    },
                    {
                        name: "Datum",
                        id: "date",
                        type: "date",
                    },
                    {
                        name: "Handschrift",
                        id: "handwriting",
                        type: "string",
                    },
                    {
                        name: "Drucke",
                        id: "print",
                        type: "string",
                    },
                    {
                        name: "Absendeort",
                        id: "sender_place",
                        type: "string",
                    },
                    {
                        name: "Briefanfang",
                        id: "letter_start",
                        type: "string",
                    },
                    {
                        name: "Briefnummer",
                        id: "letter_number",
                        type: "string",
                    },
                ],
                remaining_filters: [
                    {
                        id: "recipient_place",
                        type: "string",
                    },
                    {
                        id: "faksimilies",
                        type: "string",
                    },
                ],
            };
        },

        computed: {
            hasResults() {
                return this.letters.length > 0;
            },

            currentPage() {
                return this.pagination.page;
            }
        },

        watch: {
            currentPage() {
                this.getLetters();
            },
        },

        methods: {
            updateFilter(filter, value) {
                this.search[filter.id] = value;
            },

            startSearch() {
                // TODO: fix request triggered twice due to pagination watch
                this.pagination.page = 1;
                this.getLetters();
                this.showResults = true;
            },

            getLetters() {
                this.$http.get('/data/letters', {
                    params: {
                        page: this.pagination.page,
                        limit: this.pagination.limit,
                        mode: this.mode,
                        search: this.mode === 'simple' ? this.searchAll : this.search,
                    },
                    paramsSerializer: (params) => {
                        return qs.stringify(params, {encodeValuesOnly: true});
                    }
                }).then(response => {
                    this.letters = response.data.data;
                });
            },
        },
        components: {
            AdvancedForm,
            SearchResult,
            SearchDottedLine,
            SimpleForm,
        }
    };
</script>

<style scoped>
    .complete-container {
    }

    .search-bar {
        padding: 1rem 0 0.5rem 0;
        margin-bottom: 1rem;
    }

    .search-filter {
        min-width: 50%;
    }
</style>
