import '../bootstrap';

new Vue({
    el: '#app-container',

    data: {
        moreFields: false,
        morePeople: false,
        inputChanged: false,
    },

    mounted() {

    },

    methods: {
        checkForChanges(event) {
            if (this.inputChanged && !confirm('Es wurden Felder im Formular geändert. ' +
                'Möchtest du dieses wirklich verlassen?\n' +
                'Alle Änderungen gehen verloren!')) {
                event.preventDefault();
                event.stopPropagation();
            }

            return false;
        },

        deleteRelation(bookId, relationType, person) {
            axios({
                method: 'delete',
                url: `/librarybooks/${bookId}/relation/${relationType}`,
                data: {
                    person
                }
            }).then(response => {
                if (!this.inputChanged) {
                    location.reload(true);
                } else {
                    alert("Die Person wurde erfolgreich gelöscht. Die Änderung wird " +
                        "erst bei einem Neuladen der Seite sichtbar.\n" +
                        "Da Änderungen im Formular vorgenommen wurden, " +
                        "wurde das automatische Neuladen unterbunden.");
                }
            }).catch(response => {
                console.log(response);
            });
        }
    },

    components: {
    }
});