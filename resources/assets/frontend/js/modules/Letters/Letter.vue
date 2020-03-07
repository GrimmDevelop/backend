<template>
    <div class="flex w-full h-screen">
        <template v-if="letter">
            <div class="w-full h-full p-4 overflow-scroll">
                <zoom-image :src="letter.scans[active].url"></zoom-image>
            </div>
            <div class="w-16 bg-blue-800 text-white py-4 flex flex-col items-center">
                <div class="flex-grow">
                    right
                    <icon icon="arrow-outline-up"></icon>
                    <icon icon="add-outline"></icon>
                    <icon icon="adjust"></icon>
                    <icon icon="airplane"></icon>
                    <icon icon="backspace"></icon>
                </div>
                <div>
                    <a href="/dashboard">
                        <icon icon="layers"></icon>
                    </a>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import ZoomImage from "../../components/ui/Image/ZoomImage";

    export default {
        name: "Letter",

        data() {
            return {
                letter: null,
                active: 0,
            };
        },

        computed: {
            id() {
                return this.$route.params.id;
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

        components: {
            ZoomImage
        }
    };
</script>

<style scoped>

</style>
