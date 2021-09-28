<template>
    <div class="complete-container">
        <div class="search-form">
            <simple-search v-if="mode === 'simple'" :value="searchAll" @switch-mode="mode = 'advanced'"
                           @filter="searchAll = $event" @search="startSearch"/>

            <advanced-search v-else @switch-mode="mode = 'simple'" :value="search"
                             @filter="updateFilter(filter, $event)" @search="startSearch"/>

            <!-- simple -->
            <search-the-search-all-bar class="search-bar" @start-search="startSearch"></search-the-search-all-bar>

            <!-- advanced -->
            <div class="search-filter flex justify-center items-top">
                <div class="table">
                    <search-search-filter v-for="(filter,index) in filters" :key="index"
                                          :filter="filter" :value="search"
                                          @filter="updateFilter(filter, $event)"/>
                </div>
                <div>
                    <button class="rounded inline-block mt-2 p-2 text-white bg-blue-700 hover:bg-blue-900"
                            @click="startSearch">
                        Suchen
                    </button>
                </div>
            </div>
            <SearchAddFilterButton class="additional-search-filter"></SearchAddFilterButton>
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
    import SearchTheSearchAllBar from "./SearchTheSearchAllBar";
    import SearchSearchFilter from "./SearchSearchFilter";
    import SearchResult from "./SearchResult";

    export default {
        name: "SearchForm",

        data() {
            return {
                mode: 'simple',
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
            SearchResult,
            SearchAddFilterButton,
            SearchDottedLine,
            SearchTheSearchAllBar,
            SearchSearchFilter,
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
        min-width: 450px;
    }
</style>
