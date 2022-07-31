<template>
    <div class="container">
        <div v-for="(category, categoryName) in categorizedLetters" :key="category">
            <div class="category-title">{{ categoryName }}</div>
            <div class="search-result-cards-container">
                <div v-for="letter in category" :key="letter.id" class="search-result-card" :onclick="letterLink(letter.id)"
                     style="cursor: pointer;">
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
                                <icon v-if="letter.scans.data.length > 0" icon="letter-manuscript" style="text-align: center;"></icon>
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
        </div>
    </div>
</template>

<script>
    export default {
        name: "CategorizedSearchResults",

        computed: {
            categorizedLetters: function () {
                let categorizedLetters = {};
                for (let i = 0; i < this.letters.length; i++) {
                    let letter = this.letters[i];
                    if (categorizedLetters[letter.nachlass_category]) {
                        categorizedLetters[letter.nachlass_category].push(letter);
                    } else {
                        categorizedLetters[letter.nachlass_category] = [letter];
                    }
                }
                return categorizedLetters;
            }
        },

        data() {
            return {
                letters:
                    [
                        {
                            "id": "001",
                            "handwriting_location": "1995 Berlin SB Nl. Grimm 351, 5-6",
                            "nachlass_category": "Berlin SB Nl. Grimm 351",
                            "nachlass_page": "5-6",
                            "date": "12. Januar 1792",
                            "from_location_derived": null,
                            "from_location_historical": "Hanau",
                            "code": "17920112.0000",
                            "letter_number": null,
                            "inc": "Ich danke dir recht sehr",
                            "text": "",
                            "scans": {
                                "data": [
                                    {
                                        "url": "http://datenbank.grimm.test//media/3/00000017.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/3/conversions/00000017-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/2/00000018.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/2/conversions/00000018-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/1/00000019.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/1/conversions/00000019-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/4/00000020.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/4/conversions/00000020-thumb.jpg"
                                    }
                                ]
                            },
                            "prints": {
                                "data": []
                            },
                            "comment": {
                                "data": []
                            },
                            "senders": {
                                "data": [
                                    {
                                        "name": "Zimmer, Johann Hermann",
                                        "person_id": 1
                                    }
                                ]
                            },
                            "receivers": {
                                "data": [
                                    {
                                        "name": "Grimm, Jacob",
                                        "person_id": 2
                                    }
                                ]
                            }
                        },
                        {
                            "id": "002",
                            "handwriting_location": "1994 Berlin SB Nl. Grimm 705, 14-15",
                            "nachlass_category": "Berlin SB Nl. Grimm 705",
                            "nachlass_page": "14-15",
                            "date": "15. Juli 1815",
                            "from_location_derived": null,
                            "from_location_historical": "Meiningen",
                            "code": "18150715.0000",
                            "letter_number": null,
                            "inc": "Sie haben mich, verehrter Herr",
                            "text": "",
                            "scans": {
                                "data": [
                                    {
                                        "url": "http://datenbank.grimm.test//media/5/00000027.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/5/conversions/00000027-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/6/00000028.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/6/conversions/00000028-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/7/00000029.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/7/conversions/00000029-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/8/00000030.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/8/conversions/00000030-thumb.jpg"
                                    }
                                ]
                            },
                            "prints": {
                                "data": []
                            },
                            "comment": {
                                "data": []
                            },
                            "senders": {
                                "data": []
                            },
                            "receivers": {
                                "data": []
                            }
                        },
                        {
                            "id": "003",
                            "handwriting_location": "1995 Berlin SB Nl. Grimm 351, 7-8",
                            "nachlass_category": "Berlin SB Nl. Grimm 351",
                            "nachlass_page": "7-8",
                            "date": "4. Januar 1793",
                            "from_location_derived": null,
                            "from_location_historical": "Hanau",
                            "code": "17930104.0000",
                            "letter_number": null,
                            "inc": "Ich danke dir recht sehr",
                            "text": "",
                            "scans": {
                                "data": [
                                    {
                                        "url": "http://datenbank.grimm.test//media/42/00000021.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/42/conversions/00000021-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/43/00000022.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/43/conversions/00000022-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/44/00000023.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/44/conversions/00000023-thumb.jpg"
                                    },
                                    {
                                        "url": "http://datenbank.grimm.test//media/45/00000024.jpeg",
                                        "thumb": "http://datenbank.grimm.test//media/45/conversions/00000024-thumb.jpg"
                                    }
                                ]
                            },
                            "prints": {
                                "data": []
                            },
                            "comment": {
                                "data": []
                            },
                            "senders": {
                                "data": [
                                    {
                                        "name": "Zimmer, Johann Hermann",
                                        "person_id": 1
                                    }
                                ]
                            },
                            "receivers": {
                                "data": [
                                    {
                                        "name": "Grimm, Jacob",
                                        "person_id": 2
                                    }
                                ]
                            }
                        }
                    ]
            };
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
    .category-title {
        text-align: center;
        padding: 14px;
        font-size: 21px;
        background: #e5e7eb;
        border: 1px solid gray;
    }
</style>