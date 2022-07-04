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
                    <div class="result-item-title">Briefanfang</div>
                    <div class="result-item-content">{{ letter.inc }}</div>
                </div>
                <div v-if="letter.handwriting_location" class="result-item">
                    <div class="result-item-title">Handschrift</div>
                    <div class="result-item-content">{{ letter.handwriting_location }}</div>
                </div>
                <div v-if="letter.prints.data.length > 0" class="result-item">
                    <div class="result-item-title">gedruckt in</div>
                    <div class="result-item-content">{{ letter.prints.data.map(p => p.entry).join('; ') }}</div>
                </div>
                <div v-if="letter.comment.data.length > 0" class="result-item">
                    <div class="result-item-title">Bemerkungen</div>
                    <div class="result-item-content">{{ letter.comment.data[0] }}</div>
                </div>
                <div v-if="letter.receiver_place" class="result-item">
                    <div class="result-item-title">Empfangsort</div>
                    <div class="result-item-content">{{ letter.receiver_place }}</div>
                </div>
                <div class="result-item">
                    <div class="result-item-title">Scan(s)</div>
                    <div class="result-item-content scan-item">
                        <icon v-if="letter.scans.data.length > 0" icon="document" style="text-align: center;"></icon>
                        <icon v-else icon="close" style="text-align: center;"></icon>
                    </div>
                </div>
                <div v-if="letter.id" class="result-item">
                    <div class="result-item-title"> Brief-ID</div>
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

        methods: {
            letterLink(letterID) {
                return "window.location='letters/" + letterID + "'";
            },

            letterSender(sender) {
                if (sender.data.length > 0) {
                    return sender.data.map(person => person.name).join('; ');
                } else {
                    return "Unbekannt";
                }
            },

            letterRecipient(recipient) {
                if (recipient.data.length > 0) {
                    return recipient.data.map(person => person.name).join('; ');
                } else {
                    return "Unbekannt";
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    /*full container:*/
</style>
