<template>
    <div class="flex w-full h-screen">
        <template v-if="letter">
            <div class="relative w-full h-full p-4 overflow-hidden">
                <zoom-image v-if="hasImages" :src="imageUrl"></zoom-image>

                <div class="image-pagination flex justify-between items-center">
                    <icon icon="cheveron-left" format="cursor-pointer text-gray-600 hover:text-gray-900"
                          @click="decrement"></icon>
                    <span class="text-gray-900 whitespace-no-wrap">
                        <input :value="active" @input="setPage($event.target.value)" @focus="$event.target.select()"
                               class="page-input"> / {{ scanCount }}
                    </span>
                    <icon icon="cheveron-right" format="cursor-pointer text-gray-600 hover:text-gray-900"
                          @click="increment"></icon>
                </div>
            </div>
            <div class="w-16 bg-blue-800 text-white py-4 flex flex-col items-center">
                <div class="flex-grow flex flex-col items-center">
                    <icon icon="document" :format="windowClass(open.text)" @click="open.text = !open.text"></icon>

                </div>
                <div>
                    <a href="/dashboard">
                        <icon icon="layers"></icon>
                    </a>
                </div>
            </div>

            <window-portal :open="open.text" @closed="open.text = false">
                <letter-text :text="letter.text"></letter-text>
            </window-portal>
        </template>
    </div>
</template>

<script>
    import ZoomImage from "../../components/ui/Image/ZoomImage";
    import WindowPortal from "../../components/ui/windows/WindowPortal";
    import LetterText from "./LetterText";

    export default {
        name: "Letter",

        data() {
            return {
                letter: null,
                active: 1,
                open: {
                    text: false,
                },
            };
        },

        computed: {
            id() {
                return this.$route.params.id;
            },

            imageUrl() {
                return this.letter.scans[this.active - 1].url;
            },

            scanCount() {
                return this.letter.scans.length;
            },

            hasImages() {
                return this.scanCount > 0;
            },
        },

        watch: {
            id: {
                immediate: true,
                handler() {
                    this.$http.get(`data/letters/${this.id}`)
                        .then((response) => this.letter = response.data.data);
                }
            }
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

            windowClass(isOpen) {
                return 'cursor-pointer window-link' + (isOpen ? ' open' : '');
            },
        },

        components: {
            LetterText,
            WindowPortal,
            ZoomImage
        }
    };
</script>

<style scoped lang="scss">
    @import "../../../../sass/variables";

    .image-pagination {
        $w: 80px;
        position: absolute;
        bottom: 0;
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

    .window-link {
        margin: .5rem 0;
        color: white;

        &.open {
            color: $purple;
        }
    }

</style>
