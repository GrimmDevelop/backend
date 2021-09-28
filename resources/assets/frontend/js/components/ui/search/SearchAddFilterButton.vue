<template>
    <div class="search-add-filter-button">
        <button @click="$emit('click', $event)">
            <icon icon="add-outline" />
            weiteres Suchfeld hinzufügen
        </button>
    </div>
</template>

<script>
    export default {
        name: "SearchAddFilterButton"
    };
</script>

<style lang="scss" scoped>
    .search-add-filter-button {
        button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            border: 1px solid gray;
            border-radius: 5px;
            width: 20rem;
            margin: 1rem auto;
            background: white;
            padding: .5rem 1rem;

            &:hover {
                border-color: darken(gray, 5%);
            }
        }
    }
</style>
