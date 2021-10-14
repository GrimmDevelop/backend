<template>
    <div>
        <div class="search-filter flex justify-center items-top">
            <div class="table">
                <search-filter v-for="(filter, index) in filters" :key="index"
                                      :filter="filter" :value="search"
                                      @filter="$emit('filter', filter, $event)"/>
            </div>

        </div>
        <add-filter-button/>
        <div class="btn-container">
            <button class="btn-search"
                    @click="$emit('search')">
                Suchen
            </button>
            <button class="btn-search btn-advanced" @click="$emit('switch-mode')">
                vereinfachte Suche
            </button>
        </div>
    </div>
</template>

<script>
    import AddFilterButton from "./AddFilterButton";
    import SearchFilter from "./SearchFilter";

    export default {
        name: "AdvancedForm",

        props: {
            search: {},
            filters: {},
        },

        components: {
            SearchFilter,
            AddFilterButton
        }
    };
</script>

<style lang="scss" scoped>
    .btn-container {
        display: flex;
        justify-content: center;
    }

    .btn-search {
        background-color: #2c5282;
        color: white;
        border: none;
        border-radius: 5px 0 0 5px;
        float: left;
        padding: 0.6rem;
        align-self: center;

        &:hover {
             background-color: darken(#2c5282, 5%);
         }
    }
    .btn-advanced {
        border-radius: 0 5px 5px 0;
        padding: 0.6rem;
    }

</style>
