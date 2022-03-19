<template>
    <div class="h-screen bg-gray-200" >
        <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-300">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <a :href="homeURL" class="text-xl text-gray-600 mr-4 hover:text-gray-700">
                        Digitales Grimmarchiv
                    </a>

<!--                    <a :href="adminUrl" class="text-base text-gray-500 mx-4 hover:text-gray-600">Verwaltung</a>-->
<!--                    <a :href="letterSearch" class="text-base text-gray-500 mx-4 hover:text-gray-600">Briefsuche</a>-->
                </div>
                <external-search-bar class="external-search-bar"></external-search-bar>
            </div>
        </nav>
        <div class="w-full bg-gray-200">
            <div class="container grid grid-cols-6 gap-4 grid-rows-6 content-evenly mx-auto pt-4">
                <div class="col-span-1 row-span-3 img-wrap">
                    <img class="object-scale-down h-100%" src="https://cdn.discordapp.com/attachments/804369796288217121/948553105878949918/Unbenannt.png">
                </div>
                <div class="card col-span-3 row-span-4">
                    <div class="card-header text-xl">
                        Digitales Grimmarchiv
                    </div>
                    <div class="card-body text-base max-h-160 overflow-auto hover:overflow-scroll hover:overflow" @scroll="onScroll">
                        <td>
                            <p>Sammlung von Briefwechseln, Tagebüchern und Arbeitsmaterialien der Brüder Grimm, von Büchern aus ihrem Besitz sowie von weiteren Dokumenten und Realien des kulturellen und familiären Umfelds<br></p>
                            <p>Version 1.0<br></p>
                            <p>Konzeption und wissenschaftliche Ausführung: Berthold Friemel, Vinzenz Hoppe und Philip Kraut gemeinsam mit Felix Manczak und Elisabeth Rudolph<br></p>
                            <p>Datentechnische Modellierung und Ausführung: Friedrich Ueberreiter, Markus Daniel Mayer, Kilian Salomon, Tom Lukas Lankenau<br></p>
                            <p>Humboldt-Universität zu Berlin 2022<br></p>
                            <p>Enthält: <b>Verzeichnis von Jacob und Wilhelm Grimms Briefwechsel</b>, erarbeitet von Berthold Friemel, Stephan Bialas und Ingrid Pergande-Kaufmann gemeinsam mit Marcus Böhm, Bettina Hartz, Vinzenz Hoppe, Philip Kraut, Leonore Martin, Claudia Priemer unter Mitwirkung von Ludwig Denecke, Uwe Meves und Ruth Reiher. Version 5.0, überarbeitet von Berthold Friemel, Vinzenz Hoppe und Philip Kraut gemeinsam mit Felix Manczak und Elisabeth Rudolph<br></p>
                            <p>Humboldt Universität zu Berlin 2022<br></p>
                            <p><br>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>
                            <p class="text-right text-gray-500">Weiterlesen ...</p>
                        </td>
                    </div>
                </div>
                <div class="card col-span-2 row-span-2">
                    <!--<iframe style="position: relative; height: 100%; width: 100%;" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    -->
                    <img src="https://cdn.discordapp.com/attachments/804369796288217121/950377549836468254/grimm.png" style="position: relative; height: 100%; width: 100%;">
                </div>
                <div class="card col-span-2 row-span-4">
                    <div class="card-header text-xl ">
                        Module des Archivs
                    </div>
                    <div class="card-body text-base align-left p-0">
                        <div class="grid-rows-4 ">
                            <a :href="letterSearch">
                                <div class="module-button"><b>Briefe von und an Jacob und Wilhelm Grimm</b><br>
                                    <p>-- Briefe im Besitz der Staatsbibliothek zu Berlin (ca. 11.000)</p>
                                    <p>-- Briefwechsel zum „Deutschen Wörterbuch“ <a class="text-gray-600">(in Vorbereitung)</a><br></p>
                                </div>
                            </a>
                            <a>
                                <div class="module-button"><b>Tagebücher und Kalender der Brüder Grimm</b>
                                    <p class="text-gray-600">(in Vorbereitung)<br></p>
                                </div>
                            </a>
                            <a>
                                <div class="module-button"><b>Arbeitsmaterialien der Brüder Grimm</b>
                                    <p class="text-gray-600">(in Vorbereitung)</p>
                                    <p>-- Notizbücher<br></p>
                                </div>
                            </a>
                            <a>
                                <div class="module-button border-none"><b>persönliche Bibliothek der Brüder Grimm</b>
                                    <p class="text-gray-600">(in Vorbereitung)</p>
                                    <p>--persönliche Handbibliothek der Brüder Grimm zu den „Kinder- und Hausmärchen“<br></p>
                                </div>
                            </a>
                        </div>
                        <!-- <ul class="list-disc">
                            <li class="mb-4"><a :href="letterSearch" class="py-2 px-4 mb-2 border-gray-400 bg-gray-200 hover:bg-gray-100 text-gray-700 hover:text-gray-500"><b>Briefe von und an Jacob und Wilhelm Grimm</b></a><br>
                                <p>-- Briefe im Besitz der Staatsbibliothek zu Berlin (ca. 11.000)</p>
                                <p>-- Briefwechsel zum „Deutschen Wörterbuch“ <a class="text-gray-600">(in Vorbereitung)</a><br></p>
                            </li>
                            <li class="mb-4"><b>Tagebücher und Kalender der Brüder Grimm</b>
                                <p class="text-gray-600">(in Vorbereitung)<br></p>
                            </li>
                            <li class="mb-4"><b>Arbeitsmaterialien der Brüder Grimm</b>
                                <p class="text-gray-600">(in Vorbereitung)</p>
                                <p>-- Notizbücher<br></p>
                            </li>
                            <li class=""><b>persönliche Bibliothek der Brüder Grimm</b>
                                <p class="text-gray-600">(in Vorbereitung)</p>
                                <p>--persönliche Handbibliothek der Brüder Grimm zu den „Kinder- und Hausmärchen“<br></p>
                            </li>
                        </ul> -->
                    </div>
                </div>
                <div class="col-span-1"></div>
                <div class="card col-span-4">
                    <div class="flex flex-row card-body img-wrap max-h-32 max-w-full">
                        <img class="basis-3/20 min-w-0 object-scale-down h-100%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Huberlin-logo.svg/1200px-Huberlin-logo.svg.png" alt="Humboldt-Universität zu Berlin"/>
                        <img class="basis-3/20 min-w-0 object-scale-down h-100%" src="https://cdn.discordapp.com/attachments/804369796288217121/950337715587645500/sozlogo.jpg" alt="Grimm-Sozietät zu Berlin e.V."/>
                        <img class="basis-3/20 min-w-0 object-scale-down h-100%" src="https://pbs.twimg.com/profile_images/1303703216471912448/pH0ySXa7_400x400.png" alt="Universitätsbibliothek HUB"/>
                        <img class="basis-3/20 min-w-0 object-scale-down h-1%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Logo_Staatsbibliothek_zu_Berlin.svg/2560px-Logo_Staatsbibliothek_zu_Berlin.svg.png" alt="Staatsbibliothek zu Berlin"/>
                        <img class="basis-2/5 min-w-0 object-scale-down h-100%" src="https://www.oclc.org/content/dam/oclc/member-stories/images/logos/sub-gottingen_logo.jpg" alt="UB Göttingen"/>
                    </div>
                </div>
                <div class="card col-span-4">
                    <div class="flex flex-row card-body img-wrap max-h-32 max-w-full">
                        <p class="text-gray-600 basis-2/20">Förderer:</p>
                        <img class="basis-6/20 min-w-0 object-scale-down h-100%" src="https://www.ici-berlin.org/wp-content/uploads/2017/04/DFG_logo_sq-600x450.jpg" alt="Deutsche Forschungsgemeinschaft"/>
                        <img class="basis-6/20 min-w-0 object-scale-down h-100%" src="https://www.ici-berlin.org/wp-content/uploads/2021/01/Sponsor-2019-logo-senatsverwaltung-kultur-und-europa-1-600x372.jpg" alt="Senatsverwanltung Berlin"/>
                        <img class="basis-6/20 min-w-0 object-scale-down h-100%" src="https://www.zib.de/sites/default/files/styles/frontpage-news/public/event_images/digiS_logo_ZIB_0.jpg?itok=cu2Xzb-2" alt="digiS"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import ExternalSearchBar from "./ExternalSearchBar";
    export default {
        name: "Home",
        components: {ExternalSearchBar},
        data() {
            return {
                showMenu: false,
                scrolledBottom: false,
                scrolledTop: true,

            };
        },
        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
            },
            onScroll ({ target: { scrollTop, clientHeight, scrollHeight }}) {
                if (!this.scrolledBottom) {
                    if (scrollTop + clientHeight >= scrollHeight) {
                        this.scrolledBottom = true;
                    }
                } else {
                    if (scrollTop + clientHeight <= scrollHeight) {
                        this.scrolledBottom = false;
                    }
                }
            },
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

<style lang="scss" scoped>
    @import 'resources/assets/frontend/sass/app.scss';
    .external-search-bar {
        float: right;
    }

    .img-wrap {
        position: relative;
        /*
        overflow: hidden;
        */

    }

    .module-button {
        background: white;
        border-bottom-color: $gray-300;
        border-bottom-width: 2px;
        padding: 2rem 1rem;
    }

    .module-button:hover {
        background-color: $gray-100;
    }

    /*
    .fade-out {
        -webkit-mask-image: linear-gradient(180deg, #000 40%, transparent)
    }
    */
    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: $gray-100;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: $gray-200;
        border-radius: 2px;
        border-color: $gray-300;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>