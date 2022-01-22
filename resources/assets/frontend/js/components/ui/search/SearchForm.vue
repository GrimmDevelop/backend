<template>
    <div class="complete-container">
        <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-300">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <a :href="homeURL" class="text-lg text-gray-600 mr-4 hover:text-gray-700">
                        Grimmbriefwechsel
                    </a>
                    <a :href="adminUrl" class="text-base text-gray-500 mx-4 hover:text-gray-600">Verwaltung</a>
                    <a :href="letterSearch" class="text-base text-gray-500 mx-4 hover:text-gray-600">Briefsuche</a>
                </div>
            </div>
        </nav>
        <div class="card m-auto">
            <div class="card-header text-xl flex justify-between">
                <a>Briefsuche</a>
                <label for="toogleA" class="flex items-center cursor-pointer">
                    <!-- toggle -->
                    <div class="relative">
                        <!-- input -->
                        <input id="toogleA" type="checkbox" class="sr-only" @click="changeMode()"/>
                        <!-- line -->
                        <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                        <!-- dot -->
                        <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
                    </div>
                    <!-- label -->
                    <div class="ml-3 text-gray-400 text-base">
                        Erweiterte Suche
                    </div>
                </label>
            </div>
            <div class="card-body">
                <div class="search-form" :class="{ 'search-form-centered': !hasResults }">
                    <simple-form v-if="simple_mode == true" :value="searchAll"
                                 @filter="searchAll = $event" @search="startSearch"/>

                    <advanced-form v-else :search="search"
                                   @filter="updateFilter" @search="startSearch"/>
                </div>
            </div>
        </div>
        <div class="search-result-container" v-if="showResults">
            <dotted-line class="dotted-line"></dotted-line>
            <spinner class="result-loader" v-if="searching"></spinner>
            <div v-if="hasResults">
                <search-result :letters="letters"></search-result>
                <search-pagination @setPage="paginationSetPage" :pagination="pagination"></search-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import qs from 'qs';

    import DottedLine from "./DottedLine";
    import SimpleForm from "./SimpleForm";
    import SearchResult from "./SearchResult";
    import AdvancedForm from "./AdvancedForm";
    import SearchPagination from "./SearchPagination";
    import Spinner from "../Spinner";

    export default {
        name: "SearchForm",

        data() {
            return {
                simple_mode: true,
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
                    from_location_historical: "",
                    from_location_derived: "",
                    inc: "",
                    id: "",
                },
                pagination: {
                    page: 1,
                    limit: 9,
                    lastPage: 0,
                },
                letters: [],
                showResults: false,
                searching: false,
            };
        },

        computed: {
            hasResults() {
                try {
                    return this.letters.length > 0;
                } catch (error) {
                    return false;
                }

            },

            currentPage() {
                return this.pagination.page;
            },
            adminUrl() {
                return window.Laravel.adminUrl;
            },
            letterSearch() {
                return "/letters";
            },
            homeURL() {
                return "";
            },
        },

        watch: {
            currentPage() {
                this.getLetters();
            },
        },

        methods: {
            changeMode() {
                this.simple_mode = !this.simple_mode;
                console.log(this.simple_mode);
            },

            updateFilter(filter, value) {
                this.search[filter.id] = value;
                if (filter.name === "Absendeort") { // should we also search for the "from_location_derived"? (But I think with a logical or?)
                    this.search["from_location_historical"] = value;
                }
            },

            startSearch() {
                // TODO: fix request triggered twice due to pagination watch
                this.pagination.page = 1;
                this.getLetters();
                this.showResults = true;
            },

            getLetters() {
                this.searching = true;
                this.$http.get('/data/letters', {
                    params: {
                        page: this.pagination.page,
                        limit: this.pagination.limit,
                        mode: this.mode,
                        search: this.search,
                        searchAll: this.searchAll,
                    },
                    paramsSerializer: (params) => {
                        return qs.stringify(params, {encodeValuesOnly: true});
                    }
                }).then(response => {
                    this.searching = false;
                    this.letters = response.data.data;
                    try {
                        this.pagination.lastPage = response.data.meta.last_page;
                    } catch(error) {
                        this.pagination.lastPage = 1;
                    }
                });
            },

            paginationSetPage(number) {
                this.pagination.page = number;
            },
        },
        components: {
            AdvancedForm,
            SearchResult,
            DottedLine,
            SimpleForm,
            SearchPagination,
            Spinner,
        }
    };
</script>

<style lang="scss" scoped>
    @import "~@/sass/variables";
    .result-loader{
        background-color: $gray-200;
    }
    .search-form{
        padding-top: 2rem;
    }

    .complete-container {
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: $gray-200;
    }

    .search-form-centered {
        margin-top: auto;
        margin-bottom: auto;
    }

    .current-searching-container{
        margin-left: auto;
        margin-right: auto;
    }

    .search-result-container{

    }

    .search-bar {
        padding: 1rem 0 0.5rem 0;
        margin-bottom: 1rem;
    }

    .search-filter {
        min-width: 50%;
    }

    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: $gray-600;
    }
</style>
