<template>
    <div class="search-all-bar">
        <input class="the-search-all-bar" v-model="searchAll" v-on:keyup.enter="forwarding"
               placeholder="Alles durchsuchen"/>
        <button class="btn-search magnifier" type="submit" @click="forwarding">
            <icon icon="search" class="text-gray-600"/>
        </button>
    </div>
</template>

<script>
    export default {
        name: "ExternalSearchBar",

        data() {
            return {
                searchAll: "",
            };
        },

        methods: {
            forwarding() {
                this.$router.push({path: '/letters', query: {search: this.searchAll}});
            },
        },
    };
</script>

<style lang="scss" scoped>
    @import "~@/sass/variables";

    .search-all-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        //width: 700px;
    }

    .the-search-all-bar {
        border: thin solid $gray-300;
        border-radius: 5px 0 0 5px;
        width: 75%;
        font-size: 20px;
        padding: 0.5rem 1rem;
    }

    .magnifier {
        width: 3rem;
        height: 3rem;
    }

    .btn-search {
        background-color: $gray-200;
        color: black;
        border: none;
        border-radius: 0 5px 5px 0;
        padding: 0.85rem;

        &:hover {
            background-color: darken($gray-200, 5%);
        }
    }

    .btn-advanced {
        border-radius: 5px;
        margin-left: 1.5rem;
        padding: 0.4rem;
    }
</style>