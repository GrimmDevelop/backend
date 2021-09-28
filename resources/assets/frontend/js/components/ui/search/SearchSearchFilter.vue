<template>
    <div class="table-row my-4">
        <div class="table-cell py-2 px-1 text-right">
            {{ filter.name }}:
        </div>
        <div v-if="filter.type === 'date'" class="table-cell py-2 px-1">
            <input class="search-filter-content-date" type="date" @input="updateFilterDateValue($event, 'from')"
                   :value="search[filter.id].from"> -
            <input class="search-filter-content-date" type="date" @input="updateFilterDateValue($event, 'to')"
                   :value="search[filter.id].to">
        </div>
        <div v-if="filter.type === 'string'" class="table-cell py-2 px-1">
            <input class="search-filter-input" type="search" :placeholder="placeholder" :value="search[filter.id]"
                   @input="updateFilterValue">
        </div>
        <div v-if="filter.type === 'select'" class="table-cell py-2 px-1">
            <v-select class="search-filter-content-select" :value="search[filter.id]" :options="list"
                      @input="updateFilterValue"></v-select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchSearchFilter",
        props: {
            filter: {},
            search: {},
        },
        data() {
            return {
                list: [
                    "Grimm, Wilhelm",
                    "Grimm, Jacob"
                ],
                placeholder: "Eingeben...",
            };
        },
        computed: {
            showDate() {
                return this.type === "date";
            },
            // showListing() {
            //     return this.listing !== [];
            // }
        },

        methods: {
            updateFilterValue(event) {
                const value = typeof event === 'object' ? event.target.value : event;

                this.$emit('filter', value);
            },

            updateFilterDateValue(event, position) {
                const value = {...this.value};

                value[position] = event.target.value;

                this.$emit('filter', value);
            },
        },
    };
</script>

<style scoped>
    .search-filter-entry {
        display: grid;
        grid-template-rows: auto;
        grid-template-columns: 0.4fr 0.6fr;
        grid-template-areas: "search-filter-name search-filter-content";
        padding: 0.25rem 0.25rem;
    }

    .search-filter-name {
        grid-area: search-filter-name;
        margin-left: auto;
        padding-right: 1rem;
    }

    .search-filter-content {
        grid-area: search-filter-content;
        margin-right: auto;
    }

    .search-filter-input {
        border: 1px solid gray;
        border-radius: 5px;
        width: 15rem;
        color: gray;
    }

    .search-filter-content-date {
        border: 1px solid gray;
        border-radius: 5px;
        width: 7rem;
        color: gray;
    }

    .search-filter-content-select {
        width: 15rem;
    }
</style>
