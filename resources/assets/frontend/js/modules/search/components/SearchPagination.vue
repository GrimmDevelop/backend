<template>
    <div>
        <div class="image-pagination">
            <icon icon="cheveron-outline-left"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="decreasePage">
            </icon>
            <span class="text-gray-900 whitespace-nowrap">
                <input :value="pagination.page" @input.enter="setPage"
                       class="page-input cursor-pointer">/ {{ pagination.lastPage }}
            </span>
            <icon icon="cheveron-outline-right"
                  format="cheveron-outline-right cursor-pointer text-gray-600 hover:text-gray-900"
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

            setPage(event) {
                const page = Math.min(Math.max(1, parseInt(event.target.value)), this.pagination.lastPage);

                this.$emit('setPage', page);
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
        padding: 0.7rem;
    }

    .page-input {
        width: 3rem;
        border: 1px solid transparent;
        padding: 0;
        margin: 0;
        background: transparent;
        text-align: center;

        &:focus {
            border: 1px solid black;
        }
    }

    .cheveron-outline-right {
        margin-left: 0.3rem;
    }
</style>