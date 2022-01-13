<template>
    <div class="flex h-screen items-center justify-center">
        <div class="bg-blue-800 px-16 py-10 text-center text-white">
            <h1 class="p-2 text-2xl font-extralight">Hey, there!</h1>

            <div class="flex justify-center">
                <a :href="adminUrl" class="p-2 flex hover:bg-blue-900 items-center">
                    <icon icon="layers" class="mr-2"></icon>
                    <span class="caption">Verwaltung</span>
                </a>
                <a :href="letterSearch" class="p-2 flex hover:bg-blue-900 items-center">
                    <icon icon="search" class="mr-2"></icon>
                    <span class="caption">Briefsuche</span>
                </a>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",

        computed: {
            adminUrl() {
                return window.Laravel.adminUrl;
            },
            letterSearch() {
                return "https://grimm.test/lettersearch";
            }
        },
    };
</script>

<style scoped>

</style>