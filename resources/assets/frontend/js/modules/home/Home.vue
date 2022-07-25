<template>
    <div class="bg-gray-200 min-h-screen">
        <nav-bar>
            <external-search-bar class="external-search-bar"></external-search-bar>
        </nav-bar>
        <div class="container grid gap-4 content-evenly mx-auto py-4">
            <div class="main card">
                <div class="card-header text-xl">
                    Projektbeschreibung
                </div>
                <div class="card-body text-base overflow-auto hover:overflow-scroll hover:overflow"
                     @scroll="onScroll">
                    <div class="grid grid-cols-7">
                        <div class="col-span-1">
                            <svg viewBox="0 0 1044 1568"
                                 height="110%"
                                 width="100%"
                                 style="color: #4b5563;">
                                <use xlink:href="/images/home/grimm.svg#image"></use>
                            </svg>
                        </div>
                        <div class="col-span-6">
                            <p>
                                <b>Sammlung von Briefwechseln, Tagebüchern und Arbeitsmaterialien der Brüder Grimm, von
                                    Büchern aus ihrem Besitz sowie von weiteren Dokumenten und Realien des kulturellen und
                                    familiären Umfelds</b><br><br>
                            </p>
                            <p>Version 1.0<br></p>
                            <p>Konzeption und wissenschaftliche Ausführung: Berthold Friemel, Vinzenz Hoppe und Philip
                                Kraut gemeinsam mit Felix Manczak und Elisabeth Rudolph<br></p>
                        </div>
                    </div>

                    <p>Datentechnische Modellierung und Ausführung: Friedrich Ueberreiter, Markus Daniel Mayer,
                        Kilian Salomon, Tom Lukas Lankenau, Alexander Kerpen<br></p>
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
                        Beta-Version bietet daher auch eine überarbeitete neue Version 5.0 des Briefverzeichnisses.
                        Das Grimm-Briefverzeichnis war und ist die bisher einzige Publikation, die anstrebt, den
                        Briefwechsel der Brüder Grimm vollständig zu erfassen. Das vorliegende Werk enthält ein
                        chronologisches Verzeichnis der einzelnen Briefe von und an Jacob und Wilhelm Grimm erstmals
                        unter anderem Anspruch als dem eines privaten Hilfsmittels. Die Richtung des Verzeichnisses auf
                        Vollständigkeit entspricht einer Tendenz neuerer Briefeditionen (spätestens seit der
                        Sophien-Ausgabe von Goethes Werken und F. Strehlkes vorausgegangenem Verzeichnis der Briefe),
                        die sich auf Gesamterfassungen stützen wollen und sich gerade für die wichtigen, aber naturgemäß
                        weit verstreuten ausgegangenen Briefe eines Autors nicht nur auf das verlassen können, was eine
                        oftmals vom Zufall bestimmte Rezeption bisher zutage förderte.

                    <p class="text-right text-gray-500">
                        <a href="http://www.grimmnetz.de/bv/vorbemerkungen/vorbemerkungen.html">
                            Weiterlesen ...
                        </a>
                    </p>
                </div>
            </div>
            <div class="video card">
                <iframe class="responsive-iframe"
                        src="https://www.youtube.com/embed/0Ir-vnKwd5w"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
            <div class="modules card">
                <div class="card-header text-xl ">
                    Module des Archivs
                </div>
                <div class="module-button">
                    <a :href="letterSearch">
                        <b>
                            Briefe von und an Jacob und Wilhelm Grimm
                        </b>
                    </a>
                    <img class="w-20 float-right"
                         src="/images/search/bvlogo_y.png">
                    <span class="float-left flex align-center">
                        <input type="text"
                               v-model="searchAll"
                               v-on:keyup.enter="forwarding"
                               placeholder=" Alle Briefe durchsuchen "
                               name="search"
                               class="border border-solid border-black rounded">
                        <button type="submit"
                                @click="forwarding"
                                class="flex items-center">
                            <icon icon="search"
                                  class="text-gray-600 mx-2"/>
                        </button>
                    </span>
                    <p class="clear-both sub-item">
                        Briefe im Besitz der Staatsbibliothek zu Berlin (ca. 11.000)
                    </p>
                    <p class="text-gray-600 sub-item">
                        Briefwechsel zum „Deutschen Wörterbuch“
                        <a class="text-gray-600">
                            (in Vorbereitung)
                        </a>
                        <br>
                    </p>
                </div>
                <div class="module-button text-gray-600">
                    <b>
                        Tagebücher und Kalender der Brüder Grimm
                    </b>
                    <p class="text-gray-600 sub-item">
                        (in Vorbereitung)
                        <br>
                    </p>
                </div>
                <div class="module-button text-gray-600">
                    <b>
                        Arbeitsmaterialien der Brüder Grimm
                    </b>
                    <p class="text-gray-600">
                        (in Vorbereitung)
                    </p>
                    <p class="sub-item">
                        Notizbücher
                        <br>
                    </p>
                </div>
                <div class="module-button text-gray-600">
                    <b>
                        persönliche Bibliothek der Brüder Grimm
                    </b>
                    <p class="text-gray-600">
                        (in Vorbereitung)
                    </p>
                    <p class="sub-item">
                        persönliche Handbibliothek der Brüder Grimm zu den
                        <br>„Kinder- und
                        Hausmärchen“
                        <br>
                    </p>
                </div>
            </div>
            <div class="spons card">
                <img src="/images/home/sponsoren.png" class="p-2 object-cover">
            </div>
            <div class="foerd card">
                <img class="p-2 object-cover" src="/images/home/foerderer.png">
            </div>
        </div>
        <div class="mt-auto">
            <p class="text-center card mt-4">
                <a href="/impressum">Impressum</a>
            </p>
        </div>
    </div>
</template>

<script>

    import ExternalSearchBar from "../search/components/ExternalSearchBar";
    import NavBar from "../../components/ui/NavBar/NavBar";

    export default {
        name: "Home",
        components: {NavBar, ExternalSearchBar},
        data() {
            return {
                scrolledBottom: false,
                scrolledTop: true,
                searchAll: "",
            };
        },
        methods: {
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
            forwarding() {
                this.$router.push({path: '/letters', query: {search: this.searchAll}});
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

    .container {
        display: grid;
        grid-template-columns: 3fr 2fr;
        grid-template-rows: 290px 1fr min-content;
        grid-template-areas:
            "main video"
            "main modules"
            "spons foerd";
    }
    .main {
        grid-area: main;
    }
    .video {
        grid-area: video;
    }
    .modules {
        grid-area: modules;
    }
    .spons {
        grid-area: spons;
    }
    .foerd {
        grid-area: foerd;
    }
    
    @media only screen and (max-width: 850px) {
        .container {
            grid-template-columns: 1fr;
            grid-template-rows: auto 290px repeat(3, auto);
            grid-template-areas:
                "main"
                "video"
                "modules"
                "spons"
                "foerd";
        }
        
    }

    .external-search-bar {
        float: right;
    }

    .img-wrap {
        position: relative;
        height: 100%;
        width: auto;
        /*
        overflow: hidden;
        */

    }

    .module-button {
        background: white;
        border-bottom-color: $gray-300;
        border-bottom-width: 2px;
        padding: 1rem 1rem;
    }

    .sub-item {
        margin-left: 10px;
        position: relative;
    }

    .sub-item::before {
        content: "•";
        position: absolute;
        left: -10px;
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

    .responsive-iframe {
        width: 100%;
        height: 100%;
    }
</style>