<template>
    <div class="h-screen bg-gray-200" >
        <nav class="navbar navbar-light navbar-expand-lg p-4 bg-white border-b-2 border-gray-300">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
                    <a :href="homeURL" class="text-lg text-gray-600 mr-4 hover:text-gray-700">
                        Digitales Grimmarchiv
                    </a>
                    <a :href="adminUrl" class="text-base text-gray-500 mx-4 hover:text-gray-600">Verwaltung</a>
                    <a :href="letterSearch" class="text-base text-gray-500 mx-4 hover:text-gray-600">Briefsuche</a>
                </div>
            </div>
        </nav>
        <div class="w-full bg-gray-200">
            <div class="container grid grid-cols-4 gap-4 grid-rows-6 content-evenly mx-auto pt-4">
                <div class="card col-span-3 row-span-4">
                    <div class="card-header text-xl">
                        Digitales Grimmarchiv
                    </div>
                    <div class="card-body text-base max-h-160 overflow-auto hover:overflow-scroll hover:overflo" @scroll="onScroll">
                        <td>
                            <p><b>Vorbemerkungen zur Version 3.0 (2004)</b></p>
                            <p><b>Das vorliegende Werk enthält ein chronologisches Verzeichnis der einzelnen Briefe von und an Jacob und Wilhelm Grimm erstmals unter anderem Anspruch als dem eines privaten Hilfsmittels. Die Richtung des Verzeichnisses auf Vollständigkeit entspricht einer Tendenz neuerer Briefeditionen (spätestens seit der Sophien-Ausgabe von Goethes Werken und F. Strehlkes vorausgegangenem Verzeichnis der Briefe), die sich auf Gesamterfassungen stützen wollen und sich gerade für die wichtigen, aber naturgemäß weit verstreuten ausgegangenen Briefe eines Autors nicht nur auf das verlassen können, was eine oftmals vom Zufall bestimmte Rezeption bisher zutage förderte.</b></p>
                            <p>Es werden hier allerdings erst gut zwei Drittel des vermuteten Gesamtbriefwechsels nachgewiesen. Die Suche und Verzeichnung der Briefe wird parallel zur Arbeit an neuen Editionen einzelner Briefwechsel fortgesetzt. Eine große Masse ermittederschlossen gedeutlicht werden: Een Teil notierte er Drucke, veBlätter im Format A 5, 62 für Jacob und 54 für Wilhelm Grimm. Für jedes Jahr, aus dem Briefe überliefert sind, legte Steinmeyer ein Blatt an und vergab für jeden Monat eine Zeile, in die in äußerster Verknappung mit Tinte oder Bleistift Angaben über die Briefe eingetragen wurden. Die Kartei repräsentiert den Kenntnisstand bis etwa 1904. Angelegt wurde sie spätestens 1891. Insgesamt sind etwa 1.700 Briefe angeführt. Da Steinmeyers Kartei der einzige erhaltengebliebene Vorläufer des von uns hiermit veröffentlichten Grimm-Briefverzeichnisses ist und sonst nur Reifferscheid in seiner alphabetischen Liste von Korrespondenten auch die Anzahl der jeweils bekannten Briefe angab, kann an dieser Stelle nochmals quantitativ resümiert werden: vor 1878 waren laut Reifferscheid 208 Einzelstücke aus dem Grimm-Briefwechsel bekannt, das sind etwa 0,7 % der hypothetisch aus der Zahl der Korrespondenten hochzurechnenden Gesamtmasse von 30.000 Briefen. Bis 1904 (Steinmeyer) erhöhte sich die Zahl bekannter Briefe auf etwa 1.700, etwa 6 %. Derzeit, im Jahr 2004, verzeichnet das Grimm-Briefverzeichnis (einschließlich einer noch nicht veröffentlichten Nebendatei mit erschlossenen Briefen) etwa 22.000 Briefe, also knapp drei Viertel der vermutlich einmal vorhanden gewesenen Briefe. Dieser Anteil liegt um etwa das Doppelte über dem Durchschnittswert bei der Überlieferung anderer privater Korrespondenzen der Neuzeit, von früheren Epochen selbstverständlich ganz zu schweigen.</p>

                        </td>
                    </div>
                </div>
                <div class="card row-span-1">
                    <iframe style="position: relative; height: 100%; width: 100%;" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="card row-span-5">
                    <div class="card-header text-xl ">
                        Module des Archivs
                    </div>
                    <div class="card-body text-base align-left">

                        <p><b>Briefe von und an Jacob und Wilhelm Grimm</b><br>
                            -- Briefe im Besitz der Staatsbibliothek zu Berlin (ca. 11.000)<br>
                            -- Briefwechsel zum „Deutschen Wörterbuch“ (in Vorbereitung)</p>

                        <p><b>Tagebücher und Kalender der Brüder Grimm</b> (in Vorbereitung)</p>
                        <p><b>Arbeitsmaterialien der Brüder Grimm</b> (in Vorbereitung)<br>
                            -- Notizbücher (in Vorbereitung)</p>

                        <p><b>persönliche Bibliothek der Brüder Grimm</b> (in Vorbereitung)<br>
                            --persönliche Handbibliothek der Brüder Grimm zu den „Kinder- und Hausmärchen“ (in Vorbereitung)</p>

                    </div>
                </div>
                <div class="card col-span-3">
                    <div class="card-body flex">
                        <img class="flex-1 object-scale-down h-20" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Huberlin-logo.svg/1200px-Huberlin-logo.svg.png" alt="Humboldt-Universität zu Berlin"/>
                        <img class="flex-1 object-scale-down h-20" src="https://iiif.deutsche-digitale-bibliothek.de/image/2/3357e9f2-d145-43bd-ab0f-20fda152fe36/full/!140,105/0/default.jpg" alt="Grimm-Sozietät zu Berlin e.V."/>
                        <img class="flex-1 object-scale-down h-20" src="https://pbs.twimg.com/profile_images/1303703216471912448/pH0ySXa7_400x400.png" alt="Universitätsbibliothek HUB"/>
                        <img class="flex-1 object-scale-down h-20" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Logo_Staatsbibliothek_zu_Berlin.svg/2560px-Logo_Staatsbibliothek_zu_Berlin.svg.png" alt="Staatsbibliothek zu Berlin"/>
                        <img class="flex-1 object-scale-down w-80" src="https://www.oclc.org/content/dam/oclc/member-stories/images/logos/sub-gottingen_logo.jpg" alt="UB Göttingen"/>
                    </div>
                </div>
                <div class="card col-span-3">
                    <div class="card-body flex">
                        <p class="text-gray-600">Förderer:</p>
                        <img class="flex-1 object-scale-down h-20" src="https://www.ici-berlin.org/wp-content/uploads/2017/04/DFG_logo_sq-600x450.jpg" alt="Deutsche Forschungsgemeinschaft"/>
                        <img class="flex-1 object-scale-down h-20" src="https://www.ici-berlin.org/wp-content/uploads/2021/01/Sponsor-2019-logo-senatsverwaltung-kultur-und-europa-1-600x372.jpg" alt="Senatsverwanltung Berlin"/>
                        <img class="flex-1 object-scale-down h-20" src="https://www.zib.de/sites/default/files/styles/frontpage-news/public/event_images/digiS_logo_ZIB_0.jpg?itok=cu2Xzb-2" alt="digiS"/>
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
                        console.log(this.scrolledBottom);
                    }
                } else {
                    if (scrollTop + clientHeight <= scrollHeight) {
                        this.scrolledBottom = false;
                        console.log(this.scrolledBottom);
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