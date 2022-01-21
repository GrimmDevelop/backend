<template>
    <div>
        <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-300">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <a :href="homeURL" class="text-lg text-gray-600 mr-4 hover:text-gray-700">
                        Grimmbriefwechsel
                    </a>
                    <a :href="adminUrl" class="text-base text-gray-500 mx-4 hover:text-gray-600">Verwaltung</a>
                    <a :href="letterSearch" class="text-base text-gray-500 mx-4 hover:text-gray-600">Briefsuche</a>
                </div>
            </div>
        </nav>
        <div class="w-full h-screen bg-gray-200">
            <div class="container grid grid-cols-3 gap-4 grid-rows-4 content-evenly mx-auto pt-4">
                <div class="card col-span-2 row-span-3">
                    <div class="card-header text-xl">
                        Arbeitsstelle Grimmbriefwechsel
                    </div>
                    <div class="card-body text-base">
                        <p>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam
                            et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est
                            Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                            diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                            voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
                            gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                            amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
                            dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                            et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                            amet.
                        </p>
                        <p>
                            Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel
                            illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui
                            blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem
                            ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                            ut laoreet dolore magna aliquam erat volutpat.
                        </p>
                        <p>
                            Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel
                            illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui
                            blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem
                            ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                            ut laoreet dolore magna aliquam erat volutpat.
                        </p>
                    </div>
                </div>
                <div class="card row-span-4">
                    <div class="card-header text-xl ">
                        Unsere Sponsoren
                    </div>
                    <div class="card-body text-base">
                        <p>Lorem</p>
                        <p>ipsum</p>
                        <p>dolor</p>
                        <p>sit</p>
                        <p>amet</p>
                    </div>
                </div>
                <div class="card col-span-2">
                    <div class="card-header text-xl">
                        Hi, die Links sind oben!
                    </div>
                </div>
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