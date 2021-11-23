<template>
    <div class="complete-container">
        <div class="search-form" :class="{ 'search-form-centered': !hasResults }">
            <simple-form v-if="mode === 'simple'" :value="searchAll" @switch-mode="mode = 'advanced'"
                         @filter="searchAll = $event" @search="startSearch"/>

            <advanced-form v-else @switch-mode="mode = 'simple'" :search="search"
                           @filter="updateFilter" @search="startSearch"/>
        </div>
        <div v-if="hasResults">
            <dotted-line class="dotted-line"></dotted-line>

            <search-result :letters="letters"></search-result>

            <span @click="pagination.page++">{{ pagination.page }}</span>
        </div>
    </div>
</template>

<script>
    import qs from 'qs';

    import DottedLine from "./DottedLine";
    import SimpleForm from "./SimpleForm";
    import SearchResult from "./SearchResult";
    import AdvancedForm from "./AdvancedForm";

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
                        search: this.search,
                        searchAll: this.searchAll,
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
            DottedLine,
            SimpleForm,
        }
    };
</script>

<style scoped>
    .complete-container {
    }
    .search-form-centered {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 50rem;
        transform: translate(-50%, -50%);
    }
    .search-bar {
        padding: 1rem 0 0.5rem 0;
        margin-bottom: 1rem;
    }

    .search-filter {
        min-width: 50%;
    }
</style>
