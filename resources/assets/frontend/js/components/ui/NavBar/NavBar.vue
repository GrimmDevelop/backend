<template>
    <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-300">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                <!--<a :href="homeURL" class="text-lg text-gray-600 mr-4 hover:text-gray-700">
                    Digitales Grimmarchiv
                </a>-->
                <button class="text-xl text-gray-600 mr-4 hover:text-gray-700" type="submit" @click="backwarding">
                    Digitales Grimmarchiv
                </button>
            </div>
            <slot></slot>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "NavBar",

        methods: {
            backwarding() {
                return this.$router.push({ path: '/'});
            }
        }
    };

</script>

<style scoped>

    .home-button{
        padding: 10px;
    }

</style>