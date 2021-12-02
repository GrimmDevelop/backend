<template>
    <div class="table-row my-4">
        <div class="table-cell py-2 px-1 text-right">
            {{ filter.name }}:
        </div>
        <div v-if="filter.type === 'date'" class="table-cell py-2 px-1">
            <input class="search-filter-content-date border border-gray-500 rounded px-2 py-1 w-full" type="date" @input="updateFilterDateValue($event, 'from')"
                   :value="value[filter.id].from"> -
            <input class="search-filter-content-date border border-gray-500 rounded px-2 py-1 w-full" type="date" @input="updateFilterDateValue($event, 'to')"
                   :value="value[filter.id].to">
        </div>
        <div v-if="filter.type === 'string'" class="table-cell py-2 px-1">
            <input class="search-filter-input border border-gray-500 rounded px-2 py-1 w-full" type="search" :placeholder="placeholder" :value="value[filter.id]"
                   @input="updateFilterValue">
        </div>
        <div v-if="filter.type === 'select'" class="table-cell py-2 px-1">
            <v-select class="search-filter-content-select" @input="updateFilterValueVSelect" @search="onSearch" :value="value[filter.id]" :options="list" placeholder="Wählen..."></v-select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchFilter",

        props: {
            filter: {},
            value: {},
        },

        data() {
            return {
                list: [
                    "Grimm, Wilhelm",
                    "Grimm, Jacob",
                    "Hirzel, Salomon",
                ],
                placeholder: "Eingeben...",
                letterPeople: [],
            };
        },
        computed: {
            showDate() {
                return this.type === "date";
            },
        },

        methods: {
            onSearch(search, loading) {
                console.log("onSearch: ", search)
                if(search.length > 2) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search(loading, search, vm) {
                vm.$http.get('/data/people', {
                    params: {
                        name: search,
                    },
                }).then(response => {
                        vm.letterPeople = response.data.data;
                        console.log('search_response_people: ', vm.letterPeople)
                    }
                );
                loading(false);
            },
            updateFilterValueVSelect(value) {
                console.log("UpdateFilter: ", value);

                this.$emit('filter', value);
            },

            updateFilterValue(event) {
                const value = typeof event === 'object' ? event.target.value : event;
                console.log("UpdateFilter: ", value);

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
    .search-filter-content-date {
        width: 10rem;
        color: gray;
    }

    .search-filter-content-select {
        width: 100%;
        color: gray;
    }
</style>
