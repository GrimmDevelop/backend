<template>
    <div class="complete-container">
        <div class="search-form" :class="{ 'search-form-centered': !hasResults }">
            <simple-form v-if="mode === 'simple'" :value="searchAll" @switch-mode="mode = 'advanced'"
                         @filter="searchAll = $event" @search="startSearch"/>

            <advanced-form v-else @switch-mode="mode = 'simple'" :search="search"
                           @filter="updateFilter" @search="startSearch"/>
        </div>
        <div class="search-result-container" v-if="showResults">
            <dotted-line class="dotted-line"></dotted-line>
            <spinner v-if="searching"></spinner>
            <div v-if="hasResults">
                <search-result :letters="letters"></search-result>
                <!--                old-->
                <!--                <span @click="pagination.page++">{{ pagination.page }}</span>-->
                <!--                new-->
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
                    inc: "",
                    id_till_2018: "",
                },
                pagination: {
                    page: 1,
                    limit: 4,
                    maxPage: 0,
                },
                letters: [],
                showResults: false,
                searching: false,
            };
        },

        computed: {
            hasResults() {
                return this.letters.length > 0;
            },

            currentPage() {
                return this.pagination.page;
            },
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
                this.searching = true;
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
                        search: this.search,
                        searchAll: this.searchAll,
                    },
                    paramsSerializer: (params) => {
                        return qs.stringify(params, {encodeValuesOnly: true});
                    }
                }).then(response => {
                    this.searching = false;
                    this.letters = response.data.data;
                    this.paginationMaxPage();
                });
            },

            paginationSetPage(number) {
                console.log(number);
                this.pagination.page = number;
            },

            paginationMaxPage(){
                this.pagination.maxPage = Math.ceil(this.letters.length / this.pagination.limit);
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

<style scoped>
    .complete-container {
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
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
</style>
