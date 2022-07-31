<template>
    <div class="container flex-column">
        <div class="float-right">
            <ul>
                <li v-for="letter in sortedLetters">
                    {{ letter.nachlass_category }}
                </li>
            </ul>
        </div>
        <div class="float-right">
            <ul>
                <li v-for="letter in sortedLetters">
                    {{ letter.nachlass_category }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CategorizedSearchResults",

        computed: {
            sortedLetters: function () {
                function compare(a, b) {
                    if (a.nachlass_category < b.nachlass_category)
                        return -1;
                    if (a.nachlass_category > b.nachlass_category)
                        return 1;
                    return 0;
                }

                return this.letters.sort(compare);
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
    };
</script>

<style scoped>

</style>