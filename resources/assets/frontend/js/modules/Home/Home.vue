<template>
    <div>
        <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-200">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <a :href="homeURL" class="text-lg text-gray-500 mr-4 hover:text-gray-600">
                        Grimmbriefwechsel
                    </a>
                    <a :href="homeURL" class="text-base text-gray-400 mx-4 hover:text-gray-500">Foo</a>
                    <a :href="homeURL" class="text-base text-gray-400 mx-4 hover:text-gray-500">Bar</a>
                    <a :href="homeURL" class="text-base text-gray-400 mx-4 hover:text-gray-500">Foobar</a>
                    <a :href="homeURL" class="text-base text-gray-400 mx-4 hover:text-gray-500">Baz</a>
                    <a :href="homeURL" class="text-base text-gray-400 mx-4 hover:text-gray-500">Qux</a>
                    <a :href="adminUrl" class="text-base text-gray-400 mx-4 hover:text-gray-500">Verwaltung</a>
                    <a :href="letterSearch" class="text-base text-gray-400 mx-4 hover:text-gray-500">Briefsuche</a>
                </div>
            </div>
        </nav>
        <div class="flex h-screen items-center justify-center bg-gray-100">
            <div class="bg-blue-800 px-16 py-10 text-center text-white">
                <h1 class="p-2 text-2xl font-extralight">Hey, die Links sind oben!</h1>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                showMenu: false
            };
        },
        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
            }
        },
        computed: {
            adminUrl() {
                return window.Laravel.adminUrl;
            },
            letterSearch() {
                return "/letters";
            },
            homeURL() {
              return "";
            },
        },
    };
</script>

<style lang="sass">
    @import 'resources/assets/frontend/sass/app.scss'
</style>