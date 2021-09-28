<template>
    <div class="search-add-filter-button">
        <button @click="$emit('click', $event)">
            <icon icon="plus-outline"></icon>
            weiteres Suchfeld hinzufügen
        </button>
    </div>
</template>

<script>
    export default {
        name: "SearchAddFilterButton"
    };
</script>

<style scoped>
    .icon-text {
        margin-left: 0.3rem;
    }

    .search-add-filter-button {
        border: 1px solid gray;
        border-radius: 5px;
        width: 15rem;
        height: 1.5rem;
        margin: 1rem auto;
        background: white;
    }
</style>
