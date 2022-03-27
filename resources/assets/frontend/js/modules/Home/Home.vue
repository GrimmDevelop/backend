<template>
    <div class="bg-gray-200 min-h-screen">
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
        <div class="container grid grid-cols-6 grid-rows-7   gap-4 content-evenly mx-auto pt-4">
            <div class="col-span-1 row-span-2 img-wrap">
                <svg viewBox="0 0 1488 2336" class="pr-20 w-50%" style="color: #4b5563;">
                    <use xlink:href="/images/home/grimm.svg#image"></use>
                </svg>
            </div>
            <div class="card col-span-3 row-span-6">
                <div class="card-header text-xl">
                    Digitales Grimmarchiv
                </div>
                <div class="card-body text-base overflow-auto hover:overflow-scroll hover:overflow"
                     @scroll="onScroll">
                    <p>Sammlung von Briefwechseln, Tagebüchern und Arbeitsmaterialien der Brüder Grimm, von
                        Büchern aus ihrem Besitz sowie von weiteren Dokumenten und Realien des kulturellen und
                        familiären Umfelds<br><br></p>
                    <p>Version 1.0<br></p>
                    <p>Konzeption und wissenschaftliche Ausführung: Berthold Friemel, Vinzenz Hoppe und Philip
                        Kraut gemeinsam mit Felix Manczak und Elisabeth Rudolph<br></p>
                    <p>Datentechnische Modellierung und Ausführung: Friedrich Ueberreiter, Markus Daniel Mayer,
                        Kilian Salomon, Tom Lukas Lankenau<br></p>
                    <p>Humboldt-Universität zu Berlin 2022<br><br></p>
                    <p>Enthält: <b>Verzeichnis von Jacob und Wilhelm Grimms Briefwechsel</b>, erarbeitet von
                        Berthold Friemel, Stephan Bialas und Ingrid Pergande-Kaufmann gemeinsam mit Marcus Böhm,
                        Bettina Hartz, Vinzenz Hoppe, Philip Kraut, Leonore Martin, Claudia Priemer unter
                        Mitwirkung von Ludwig Denecke, Uwe Meves und Ruth Reiher. Version 5.0, überarbeitet von
                        Berthold Friemel, Vinzenz Hoppe und Philip Kraut gemeinsam mit Felix Manczak und
                        Elisabeth Rudolph<br></p>
                    <p>Humboldt Universität zu Berlin 2022<br></p>
                    <p class="text-gray-600"><br>Dieses Internetangebot macht Dokumente über die Brüder Grimm, ihren
                        Umkreis und die Werke der Grimms zugänglich. Die Dokumente werden in einer sachbezogenen Ordnung
                        präsentiert und feinteilig durchsuchbar gemacht. Die Seite startet mit dem Briefwechsel der
                        Brüder Grimm. Schon die Beta-Version macht zu etwa 11.000 Briefen Scans der Originale
                        zugänglich. Diese Briefe befinden sich in der Staatsbibliothek Berlin und zum kleineren Teil in
                        der Staats- und Universitätsbibliothek Göttingen. Dass die Briefe in der Staatsbibliothek Berlin
                        vollständig digitalisiert werden konnten, ist dem Förderprogramm zur Digitalisierung von
                        Kulturgut des Landes Berlin (digiS) zu verdanken. Die Scans wurden mit der schon zuvor im
                        Internet zugänglichen Datenbank des Grimm-Briefverzeichnisses verbunden. Vorliegende
                        Beta-Version bietet daher auch eine überarbeitete neue Version 4.0 des Briefverzeichnisses.
                        Das Grimm-Briefverzeichnis war und ist die bisher einzige Publikation, die anstrebt, den
                        Briefwechsel der Brüder Grimm vollständig zu erfassen.</p>
                    <p class="text-right text-gray-500"><a href="http://www.grimmnetz.de/bv/vorbemerkungen/vorbemerkungen.html">Weiterlesen ...</a></p>
                </div>
            </div>

            <div class="card col-span-2 row-span-6">
                <div class="card-header text-xl ">
                    Module des Archivs
                </div>
                <div class="card-body text-base align-left p-0">
                    <div class="grid-rows-4 ">
                        <a :href="letterSearch">
                            <div class="module-button"><b>Briefe von und an Jacob und Wilhelm Grimm</b><br>
                                <p>• Briefe im Besitz der Staatsbibliothek zu Berlin (ca. 11.000)</p>
                                <p>• Briefwechsel zum „Deutschen Wörterbuch“ <a class="text-gray-600">(in
                                    Vorbereitung)</a><br></p>
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
                                <p>• Notizbücher<br></p>
                            </div>
                        </a>
                        <a>
                            <div class="module-button border-none"><b>persönliche Bibliothek der Brüder Grimm</b>
                                <p class="text-gray-600">(in Vorbereitung)</p>
                                <p>• persönliche Handbibliothek der Brüder Grimm zu den „Kinder- und
                                    Hausmärchen“<br></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card col-span-1 row-span-1">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/0Ir-vnKwd5w" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <div class="card col-span-6">
                <!--
                <div class="grid grid-cols-10 card-body  max-h-32 max-w-full">
                    <div class="img-wrap col-span-1">
                        <img class=""
                             src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Huberlin-logo.svg/1200px-Huberlin-logo.svg.png"
                             alt="Humboldt-Universität zu Berlin"/>
                    </div>
                    <div class="col-span-1 img-wrap">
                        <img class=""
                             src="https://cdn.discordapp.com/attachments/804369796288217121/950337715587645500/sozlogo.jpg"
                             alt="Grimm-Sozietät zu Berlin e.V."/>
                    </div>
                    <div class="col-span-1 img-wrap">
                        <img class=""
                             src="https://pbs.twimg.com/profile_images/1303703216471912448/pH0ySXa7_400x400.png"
                             alt="Universitätsbibliothek HUB"/>
                    </div>
                    <div class="col-span-3 img-wrap">
                        <img class=""
                             src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Logo_Staatsbibliothek_zu_Berlin.svg/2560px-Logo_Staatsbibliothek_zu_Berlin.svg.png"
                             alt="Staatsbibliothek zu Berlin"/>
                    </div>
                    <div class="col-span-4 img-wrap">
                        <img class="my-auto"
                             src="https://www.oclc.org/content/dam/oclc/member-stories/images/logos/sub-gottingen_logo.jpg"
                             alt="UB Göttingen"/>
                    </div>
                </div>
                -->
                <img src="/images/home/Sponsoren.png" class="p-2 w-full h-full object-cover">
            </div>
            <div class="card col-span-6 row-span-1">
                <img class="p-2 img-wrap" src="/images/home/Förderer.png">
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
            toggleNavbar: function () {
                this.showMenu = !this.showMenu;
            },
            onScroll({target: {scrollTop, clientHeight, scrollHeight}}) {
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
        height: 60%;
        width: auto;
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