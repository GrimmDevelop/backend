<template>
    <div class="bg-gray-200">
        <nav-bar />
        <div v-for="(category, categoryName) in categorizedLetters"
             :key="categoryName"
             class="card m-4">
            <div class="card-header text-xl text-center">{{ categoryName }}</div>
            <div class="search-result-cards-container p-4">
                <search-result-card v-for="letter in category" :key="letter.id" :letter="letter"/>
            </div>
        </div>
    </div>
</template>

<script>

    import SearchResultCard from "./SearchResultCard";
    import NavBar from "../../../components/ui/NavBar/NavBar";

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
                console.log(categorizedLetters);
                return categorizedLetters;
            }
        },

        data() {
            return {
                letters:
                    [
                        {
                            "id": "001",
                            "handwriting_location": "1995 Berlin SB Nl. Grimm 331, 5-6",
                            "nachlass_category": "Berlin SB Nl. Grimm 331",
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
                            "handwriting_location": "1995 Berlin SB Nl. Grimm 331, 7-8",
                            "nachlass_category": "Berlin SB Nl. Grimm 331",
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
                        },
                        {
                            "id": "ABC",
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
                            "id": "ABD",
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
                            "id": "ABE",
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
                        },
                        {
                            "id": "006",
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
                            "id": "005",
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
                            "id": "004",
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

        components: {
            NavBar,
            SearchResultCard,
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