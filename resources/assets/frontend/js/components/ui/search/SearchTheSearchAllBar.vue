<template>
    <div class="search-all-bar">
        <input class="the-search-all-bar" v-model="search" type="search" placeholder="Alles durchsuchen"/>
        <button class="btn-search" type="submit" @click="$emit('start-search')">
            <icon icon="search"/>
        </button>
    </div>
</template>

<script>
    export default {
        name: "SearchTheSearchAllBar",
        data() {
            return {
                search: "",
            };
        },
    };
</script>

<style lang="scss" scoped>
    .search-all-bar {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .the-search-all-bar {
        border: 1px solid gray;
        border-radius: 5px 0 0 5px;
        width: 35%;
        font-size: 20px;
        padding: 0.5rem 1rem;
    }

    .btn-search {
        background-color: #2c5282;
        color: white;
        border: none;
        border-radius: 0px 5px 5px 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.85rem;

        &:hover {
            background-color: darken(#2c5282, 5%);
        }
    }

</style>
