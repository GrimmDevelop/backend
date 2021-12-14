<template>
    <div>
        <div class="image-pagination">
            <icon icon="cheveron-outline-left"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="decreasePage">
            </icon>
            <span class="text-gray-900 whitespace-nowrap">
                <input :placeholder="pagination.page" :value="active" @input="setPage"
                       class="page-input cursor-pointer">/ {{ pagination.maxPage }}
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

        data() {
            return {
                active: 0
            }
        },

        mounted() {
            this.active = this.pagination.page;
        },

        methods: {
            increasePage() {
                this.$emit('setPage', this.pagination.page + 1)
            },

            decreasePage() {
                this.$emit('setPage', this.pagination.page - 1)
            },

            setPage() {
                this.$emit('setPage', this.active)
            },
        },


    }
</script>

<style scoped lang="scss">
    @import "~@/sass/variables";

    .image-pagination {
        border-radius: 5px;
        background-color: rgba(248, 239, 239, 0.5);
        display: flex;
        align-items: center;
        $w: 80px;
        position: absolute;
        bottom: 5px;
        left: 50%;
        margin-left: -($w / 2);
        width: $w;
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
</style>