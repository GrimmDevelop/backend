<template>
    <div class="table-row my-4">
        <div class="table-cell py-2 px-1 text-right">
            {{ filter.name }}:
        </div>
        <div v-if="filter.type === 'date'" class="table-cell py-2 px-1">
            <input class="search-filter-content-date search-filter-border px-2 py-1 w-full" type="date"
                   @input="updateFilterDateValue($event, 'from')"
                   :value="value[filter.id].from"> -
            <input class="search-filter-content-date search-filter-border px-2 py-1 w-full" type="date"
                   @input="updateFilterDateValue($event, 'to')"
                   :value="value[filter.id].to">
        </div>
        <div v-if="filter.type === 'string'" class="table-cell py-2 px-1">
            <input class="search-filter-input search-filter-border px-2 py-1 w-full"
                   type="search"
                   :placeholder="placeholder"
                   :value="value[filter.id]"
                   @input="updateFilterValue">
        </div>
        <div v-if="filter.type === 'select'" class="table-cell py-2 px-1">
            <v-select class="search-filter-content-select"
                      @input="updateFilterValueVSelect"
                      @search="onSearch"
                      :value="value[filter.id]"
                      :options="list"
                      :placeholder="placeholder_vselect"
                      :dropdown-should-open="dropdownShouldOpen"></v-select>
        </div>
    </div>
</template>

<script>
    import debounce from 'lodash/debounce';

    export default {
        name: "SearchFilter",

        props: {
            filter: {},
            value: {},
        },

        data() {
            return {
                list: [],
                placeholder: "Eingeben...",
                placeholder_vselect: "Namen eingeben...",
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
                if (search.length > 2) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: debounce(function (loading, search, vm) {
                vm.$http.get('/data/people', {
                    params: {
                        name: search,
                    },
                }).then(response => {
                    vm.list = response.data.data.map(person => person.assignment_source);

                    loading(false);
                });
            }, 350),

            updateFilterValueVSelect(value) { // is ok to not debounce
                this.$emit('filter', value);
            },

            updateFilterValue(event) { // is ok to not debounce
                const value = typeof event === 'object' ? event.target.value : event;
                this.$emit('filter', value);
            },

            updateFilterDateValue(event, position) { // is ok to not debounce
                const value = {...this.value[this.filter.id]};
                value[position] = event.target.value;
                this.$emit('filter', value);
            },

            dropdownShouldOpen(VueSelect){
                if (this.list.length !== 0) {
                    return VueSelect.open;
                }

                return VueSelect.search.length !== 0 && VueSelect.open;
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

    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: gray;
        opacity: 1; /* Firefox */
    }

    ::-ms-input-placeholder { /* Microsoft Edge */
        color: gray;
    }

    .search-filter-border {
        border: 1px solid rgba(60,60,60,0.26);
        border-radius: 4px;
    }
</style>
