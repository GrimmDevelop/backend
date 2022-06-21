<template>
    <div>
        <div class="image-pagination">
            <icon icon="cheveron-outline-left"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="decreasePage">
            </icon>
            <span class="page-number">{{ pagination.page }}</span>
            <span>/</span>
            <span class="page-number">{{ pagination.lastPage }}</span>
            <icon icon="cheveron-outline-right"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="increasePage">
            </icon>
        </div>
    </div>


</template>

<script>
    export default {
        name: "SearchPagination",
        props: {
            pagination: {},
        },

        methods: {
            increasePage() {
                this.$emit('setPage', Math.min(this.pagination.page + 1, this.pagination.lastPage));
            },

            decreasePage() {
                this.$emit('setPage', Math.max(1, this.pagination.page - 1));
            },
        },
    };
</script>

<style scoped lang="scss">
    @import "resources/assets/frontend/sass/_variables.scss";

    .image-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .page-number {
        margin: 0 5px;
    }
</style>