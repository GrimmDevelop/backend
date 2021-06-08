<template>
    <div class="flex w-full h-screen">
        <template v-if="letter">
            <div class="relative w-full h-full p-4 overflow-hidden">
                <zoom-image v-if="hasImages" :src="imageUrl"></zoom-image>

                <div class="image-pagination flex justify-between items-center">
                    <icon icon="cheveron-left" format="cursor-pointer text-gray-600 hover:text-gray-900"
                          @click="decrement"></icon>
                    <span class="text-gray-900 whitespace-nowrap">
                        <input :value="active" @input="setPage($event.target.value)" @focus="$event.target.select()"
                               class="page-input cursor-pointer"> / {{ scanCount }}
                    </span>
                    <icon icon="cheveron-right" format="cursor-pointer text-gray-600 hover:text-gray-900"
                          @click="increment"></icon>
                </div>
            </div>
            <div class="sidebar bg-blue-600 text-white px-2 py-4 flex flex-col"
                 :class="sidebarOpen ? 'open' : ''">
                <div class="sidebar-link hover:bg-blue-900" :class="linkClass(open.text)"
                     @click="open.text = !open.text">
                    <icon icon="document"></icon>
                    <span class="caption">Brieftext</span>
                </div>
                <div class="sidebar-link-desc">
                    {{ letter.inc }}
                </div>
                <div class="sidebar-link hover:bg-blue-900">
                    <icon icon="library"></icon>
                    <span class="caption">Apparate zum Text</span>
                </div>
                <div class="sidebar-link hover:bg-blue-900">
                    <icon icon="light-bulb"></icon>
                    <span class="caption">Sachkommentare</span>
                </div>
                <div class="sidebar-link hover:bg-blue-900" @click="sidebarOpen = !sidebarOpen">
                    <icon :icon="sidebarOpen ? 'cheveron-right' : 'cheveron-left'"></icon>
                    <span class="caption">einklappen</span>
                </div>

                <div class="flex-grow"></div>

                <a :href="adminUrl" class="sidebar-link hover:bg-blue-900">
                    <icon icon="layers"></icon>
                    <span class="caption">Verwaltung</span>
                </a>
            </div>

            <window-portal :open="open.text" @closed="open.text = false">
                <letter-text :text="letter.text"></letter-text>
            </window-portal>
        </template>
    </div>
</template>

<script>
    import ZoomImage from "@/frontend/js/components/ui/Image/ZoomImage";
    import WindowPortal from "@/frontend/js/components/ui/windows/WindowPortal";
    import LetterText from "./LetterText";

    export default {
        name: "Letter",

        data() {
            return {
                sidebarOpen: true,
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

            adminUrl() {
                return window.Laravel.adminUrl;
            },
        },

        watch: {
            id: {
                immediate: true,
                handler() {
                    this.$http.get(`/data/letters/${this.id}`)
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

            linkClass(isOpen) {
                return {
                    'open': isOpen
                };
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
    @use "sass:math";
    @import "~@/sass/variables";

    .sidebar {
        /*width: 4rem;*/
        align-items: center;

        &.open {
            min-width: 13rem;
            align-items: flex-start;
        }
    }

    .image-pagination {
        $w: 80px;
        position: absolute;
        bottom: 0;
        left: 50%;
        width: $w;
    }

    .image-pagination {
        margin-left: - math.div($w, 2);
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

    .sidebar-link {
        margin: .1rem 0;
        padding: .4rem .2rem;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;

        .sidebar.open & {
            width: 100%;
        }

        .caption {
            display: none;
            margin-left: .25rem;
            line-height: 0;
            flex-grow: 1;

            .sidebar.open & {
                display: block;
                width: 100%;
            }
        }

        &.open::after {
            content: '•';
            margin-left: .25rem;
            font-size: 18pt;
            line-height: 0;
            color: $red;
        }
    }

    .sidebar-link-desc {
        display: none;
        color: rgba(255, 255, 255, .5);

        .sidebar.open & {
            display: block;
            width: 100%;
        }
    }

</style>
