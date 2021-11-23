<template>
    <div>
        <div class="search-filter flex justify-center items-top">
            <div class="table">
                <search-filter v-for="(filter, index) in filters" :key="index"
                                      :filter="filter" :value="search"
                                      @filter="$emit('filter', filter, $event)"/>
            </div>

        </div>
        <add-filter-button v-if="remaining_filters.length > 0" :remaining_filters="remaining_filters" @addFilter="addFilter($event)"/>
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
        },

        data() {
            return {
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
                        name: "Empfangsort",
                        id: "recipient_place",
                        type: "string",
                    },
                    {
                        name: "Faksimilies",
                        id: "faksimilies",
                        type: "string",
                    },
                ],
            }
        },

        methods: {
            addFilter(event){
                let selectedElement = this.remaining_filters.filter(o => o.name === event.name)[0];
                this.filters.push(selectedElement);
                this.remaining_filters = this.remaining_filters.filter(o => o !== selectedElement);
            }
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
        margin-top: 1rem;
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
