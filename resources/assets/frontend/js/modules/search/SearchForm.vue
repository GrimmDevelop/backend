<template>
    <div class="complete-container">
        <nav-bar class="navbar">
            <img class="max-h-10" src="/images/search/bvlogo_y.png">
        </nav-bar>
        <div class="card my-4 mx-auto">
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
                    <simple-form v-if="simple_mode" :value="searchAll"
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
                <div class="top-pagination card">
                    <div>
                        {{ numberOfResults }} Ergebnisse insgesamt
                    </div>
                    <div v-if="numberOfResults > letters.length">
                        {{ letters.length }} auf der aktuellen Seite
                    </div>
                    <search-pagination @setPage="paginationSetPage" :pagination="pagination"></search-pagination>
                </div>
                <search-result :letters="letters"></search-result>
                <search-pagination class="bottom-pagination card" @setPage="paginationSetPage" :pagination="pagination"></search-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import qs from 'qs';
    import DottedLine from "../../components/ui/DottedLine";
    import SimpleForm from "./components/SimpleForm";
    import SearchResult from "./components/SearchResult";
    import AdvancedForm from "./components/AdvancedForm";
    import SearchPagination from "./components/SearchPagination";
    import Spinner from "../../components/ui/Spinner";
    import NavBar from "../../components/ui/NavBar/NavBar";

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
                    unique_code: "",
                },
                pagination: {
                    page: 1,
                    limit: 60,
                    lastPage: 0,
                },
                letters: [],
                numberOfResults: 0,
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
                return "/";
            },

            mode() {
                if (this.simple_mode){
                    return "simple";
                }
                else {
                    return "advanced";
                }
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
            },

            updateFilter(filter, value) {
                this.search[filter.id] = value;
                if (filter.name === "Absendeort") { // TODO: should we also search for the "from_location_derived"? (But I think with a logical or?)
                    this.search["from_location_historical"] = value;
                }
            },

            startSearch() {
                // TODO: fix request triggered twice due to pagination watch
                this.pagination.page = 1;
                this.getLetters();
                this.persist();
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
                    this.showResults = true;
                    try {
                        this.pagination.lastPage = response.data.meta.last_page;
                    } catch (error) {
                        this.pagination.lastPage = 1;
                    }
                    this.numberOfResults = response.data.meta.total;
                });
            },

            paginationSetPage(number) {
                this.pagination.page = number;
                this.persist();
            },

            getLocalStorage() {
                let performSearch = false;
                if (localStorage.getItem('pagination')) {
                    try {
                        this.pagination = JSON.parse(localStorage.getItem('pagination'));
                    } catch (e) {
                        localStorage.removeItem('pagination');
                    }
                }

                if (localStorage.simple_mode) {
                    this.simple_mode = localStorage.simple_mode;
                }

                if (localStorage.searchAll) {
                    performSearch = true;
                    this.searchAll = localStorage.searchAll;
                }

                if (localStorage.getItem('search')) {
                    performSearch = true;
                    try {
                        this.search = JSON.parse(localStorage.getItem('search'));
                    } catch (e) {
                        localStorage.removeItem('search');
                    }
                }

                if (performSearch) {
                    this.getLetters();
                }
            },

            persist() {
                localStorage.setItem('simple_mode', this.simple_mode);
                localStorage.setItem('searchAll', this.searchAll);
                localStorage.setItem('search', JSON.stringify(this.search));
                localStorage.setItem('pagination', JSON.stringify(this.pagination));
            },

            clearStorage() {
                localStorage.clear();
            },
        },

        mounted() {
            if(this.$route.query.search){
                this.searchAll = this.$route.query.search;
                this.startSearch();
            }
            this.getLocalStorage();
        },

        components: {
            NavBar,
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
    @import "resources/assets/frontend/sass/_variables.scss";

    .result-loader{
        background-color: $gray-200;
    }
    .search-form{
        padding-top: 2rem;
    }

    .complete-container {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: $gray-200;
    }

    .search-form-centered {
        margin-top: auto;
        margin-bottom: auto;
    }

    .current-searching-container {
        margin-left: auto;
        margin-right: auto;
    }

    .search-result-number {
        display: table;
        margin: 0 auto;
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

    .top-pagination {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: fit-content;
        padding: 12px;
        margin: auto auto 7px;
    }

    .bottom-pagination {
        width: fit-content;
        padding: 12px;
        margin: 20px auto 7px auto;
    }
</style>
