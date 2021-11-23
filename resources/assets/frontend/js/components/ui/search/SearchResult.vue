<template>
    <div class="search-result-cards-container">
        <div v-for="letter in letters" :key="letter.id" class="search-result-card" :onclick="letterLink(letter.id)"
             style="cursor: pointer;">
<!--         TODO: Probleme:
             Nicht alle Variablen sind in der letter-Variable
             Das Filtering funktioniert nicht so, wie wir uns das vorstellen.-->

            <div class="result-title">
                <span v-if="letter.from_location_historical">
                    {{ letter.from_location_historical }},
                </span>
                <span v-if="!letter.from_location_historical">
                    [{{ letter.from_location_derived }}],
                </span>
                {{ letter.date }} {{ letterSender(letter.senders) }} an {{ letterRecipient(letter.receivers) }}
            </div>
            <div class="result-properties">
                <div v-if="letter.inc" class="result-item">
                    <div class="result-item-title">Briefbeginn</div>
                    <div class="result-item-content">{{ letter.inc }}</div>
                </div>
                <div v-if="letter.handwriting_location" class="result-item">
                    <div class="result-item-title">Handschrift</div>
                    <div class="result-item-content">{{ letter.handwriting_location }}</div>
                </div>
                <div v-if="letter.prints.length > 0" class="result-item">
                    <div class="result-item-title">gedruckt in</div>
                    <div class="result-item-content">{{ letter.prints }}</div>
                </div>
                <div v-if="letter.comments" class="result-item">
                    <div class="result-item-title">Bemerkungen</div>
                    <div class="result-item-content">{{ letter.comments }}</div>
                </div>
                <div v-if="letter.receiver_place" class="result-item">
                    <div class="result-item-title">Empfangsort</div>
                    <div class="result-item-content">{{ letter.receiver_place }}</div>
                </div>
                <div class="result-item">
                    <div class="result-item-title">Scan(s)</div>
                    <div class="result-item-content scan-item">
                        <icon v-if="letter.scans.length > 0" icon="close" style="text-align: center;"></icon>
                        <icon v-else icon="document" style="text-align: center;"></icon>
                    </div>
                </div>
                <div v-if="letter.id" class="result-item">
                    <div class="result-item-title"> BriefID</div>
                    <div class="result-item-content"> {{ letter.id }}</div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchResult",

        props: {
            letters: {
                default: () => ([]),
                type: Array,
            }
        },

        data() {
            return {
                paginate: 10,
            };
        },

        computed: {
            resultNumber() {
                return this.letters.length;
            },
        },

        methods: {
            letterLink(letterID) {
                return "window.location='letters/" + letterID + "'";
            },

            letterSender(sender) {
                if (sender) {
                    return sender.join('; ');
                } else {
                    return "Unbekannt";
                }
            },

            letterRecipient(recipient) {
                if (recipient) {
                    return recipient.join('; ');
                } else {
                    return "Unbekannt";
                }
            },
        },
    };
</script>

<style>
    /*full container:*/
    .search-result-cards-container {
        display: flex;
        flex-flow: row wrap;
        gap: 2rem 4rem;
        width: 100%;
        height: 100%;
    }

    /*one result card:*/
    .search-result-card {
        border: 1px solid black;
        border-radius: 5px;
        width: 30%;
        min-width: 350px;
        max-width: 500px;
        height: fit-content;
    }

    /*result card title*/
    .result-title {
        padding: 0.3rem;
        font-size: 1.3rem;
        color: white;
        background-color: #35495d;
    }

    .result-properties {
        margin: 5px 10px;
    }

    .result-item {
        display: grid;
        grid-template-columns: 7rem 1fr;
        grid-template-areas: "item-title item-content";
        font-size: 1rem;
        margin-left: auto;
        margin-right: auto;
        /*padding-bottom: 5px;*/
        /*display: flex;*/
    }

    .result-item-title {
        grid-area: item-title;
        /*margin-left: auto;*/
        margin-right: auto;
        padding-bottom: 5px;
    }

    .result-item-content {
        grid-area: item-content;
        border-left: 1px solid black;
        padding-left: 1rem;
        padding-bottom: 5px;

        /*margin-left: auto;*/
        margin-right: auto;
    }

    /*.scan-item{*/
    /*    margin-right: auto;*/
    /*    margin-left: auto;*/
    /*}*/
</style>
