<template>
    <div class="search-all-bar">
        <input class="the-search-all-bar" :value="value" @input="$emit('filter', $event.target.value)" type="search" placeholder="Alles durchsuchen"/>
        <button class="btn-search magnifier" type="submit" @click="$emit('search')">
            <icon icon="search"/>
        </button>

        <button class="btn-search btn-advanced" @click="$emit('switch-mode')">
            erweiterte Suche
        </button>
    </div>
</template>

<script>
    export default {
        name: "SimpleForm",

        props: {
            value: {},
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

    .magnifier {
        width: 3rem;
        height: 3rem;
    }

    .btn-search {
        background-color: #2c5282;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        padding: 0.85rem;

        &:hover {
            background-color: darken(#2c5282, 5%);
        }
    }

    .btn-advanced {
        border-radius: 5px;
        margin-left: 1.5rem;
        padding: 0.4rem;
    }
</style>