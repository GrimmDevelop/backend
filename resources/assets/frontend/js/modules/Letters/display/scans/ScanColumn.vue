<template>
    <div class="card card-body w-full h-full">
        <zoom-image ref="zoomImage" v-if="hasImages" :src="imageUrl"></zoom-image>
        <div class="image-pagination">
            <icon icon="cheveron-left"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="decrement">
            </icon>
            <span class="text-gray-700 whitespace-nowrap">
                <input :value="active" @input="setPage($event.target.value)"
                       @focus="$event.target.select()"
                       class="page-input cursor-pointer">/ {{ scanCount }}
            </span>
            <icon icon="cheveron-right"
                  format="cursor-pointer text-gray-600 hover:text-gray-900"
                  @click="increment">
            </icon>
        </div>
    </div>
</template>

<script>
    import ZoomImage from "@/frontend/js/components/ui/Image/ZoomImage";

    export default {
        name: "ScanColumn",

        data() {
            return {
                active: 1,
            };
        },

        props: {
            letter: {},
        },

        computed: {
            imageUrl() {
                return this.letter.scans[this.active - 1].url;
            },

            hasImages() {
                return this.scanCount > 0;
            },

            scanCount() {
                return this.letter.scans.length;
            },
        },

        methods: {
            decrement() {
                this.setPage(this.active - 1);
            },

            increment() {
                this.setPage(this.active + 1);
            },

            setPage(page) {
                page = parseInt(page);

                if (isNaN(page)) {
                    return;
                }

                this.active = Math.max(1, Math.min(this.scanCount, page));
            },

            resetImagePosition() {
                this.$refs.zoomImage.resetPosition();
            },
        },

        components: {
            ZoomImage,
        },
    };
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