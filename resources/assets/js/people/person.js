import '../bootstrap';

import PrintsList from './components/PrintsList';
import InheritancesList from './components/InheritancesList';
import ReferencesList from './components/ReferencesList';
import BooksList from './components/BooksList';

import levenshtein from '../utils/Levenshtein';

new window.Vue({

    el: '#app-container',

    data: {
        form: null
    },

    mounted() {
        this.form = this.$refs.personForm;
    },

    components: {
        PrintsList,
        InheritancesList,
        ReferencesList,
        BooksList,
    }
});

/**
 * On save, we calculate the change in the name and according to that,
 * we will ask if the user wants to really change the entry
 * to prevent accidental overwriting.
 */
window.$('#person-editor').on('submit', function (event) {
    let prevLastName = window.$('input[name=prev_last_name]').val();
    let prevFirstName = window.$('input[name=prev_first_name]').val();
    let prevName = `${prevLastName}, ${prevFirstName}`;

    let currentLastName = window.$('input[name=last_name]').val();
    let currentFirstName = window.$('input[name=first_name]').val();
    let currentName = `${currentLastName}, ${currentFirstName}`;

    let distance = levenshtein(prevName, currentName);

    if (distance > 3) {
        let message = `Der Name wurde an ${distance} Stellen bearbeitet. Soll der Datensatz wirklich geändert werden?\n\nBisheriger Name: ${prevName}\n\nNeuer Name: ${currentName}`;
        if (!confirm(message)) {
            event.preventDefault();
        }
    }
});
