<template>
    <div>
        <div class="image-pagination">
            <icon icon="cheveron-outline-left"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="decreasePage">
            </icon>
            <span class="text-gray-900 whitespace-nowrap">
                <input :value="pagination.page" @input="setPage"
                       class="page-input cursor-pointer">/ {{ pagination.lastPage }}
            </span>
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

            setPage() {
                this.$emit('setPage', this.active);
            },
        },


    };
</script>

<style scoped lang="scss">
    @import "~@/sass/variables";

    .image-pagination {
        background-color: rgba(248, 239, 239, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.7rem;
    }

    .page-input {
        width: 1rem;
        border: 1px solid transparent;
        padding: 0;
        margin: 0;
        background: transparent;
        text-align: center;

        &:focus {
            border: 1px solid black;
        }
    }

    .cheveron-outline-right{
        margin-left: 0.4rem;
    }
</style>