<template>
    <div>
        <div class="search-filter flex justify-center items-top">
            <div class="table">
                <search-search-filter v-for="(filter, index) in filters" :key="index"
                                      :filter="filter" :value="search"
                                      @filter="$emit('filter', filter, $event)"/>
            </div>
            <div>
                <button class="rounded inline-block mt-2 p-2 text-white bg-blue-700 hover:bg-blue-900"
                        @click="$emit('search')">
                    Suchen
                </button>
            </div>
        </div>
        <search-add-filter-button/>
    </div>
</template>

<script>
    import SearchAddFilterButton from "./SearchAddFilterButton";
    import SearchSearchFilter from "./SearchSearchFilter";

    export default {
        name: "AdvancedForm",

        props: {
            search: {},
            filters: {},
        },

        components: {
            SearchSearchFilter,
            SearchAddFilterButton
        }
    };
</script>

<style scoped>

</style>