import '../bootstrap';

import Upload from '../utils/Upload';
import Echo from 'laravel-echo';

window.Echo = new Echo({
    'broadcaster': 'pusher',
    'key': window.PUSHER_KEY,
    'cluster': window.PUSHER_CLUSTER,
});

new window.Vue({
    el: '#app-container',

    data: {
        started: false,
        done: false,
        databases: [],
        messages: [],
    },

    mounted() {
        window.Echo.private(`import.user.${window.USER_ID}`)
            .listen('ImportProgress', (e) => {
                this.messages.push({
                    type: "update",
                    entity: e.type,
                    amount: e.amount,
                    total: e.total
                });
            })
            .listen('ImportDone', () => {
                this.done = true;
                this.started = false;
            });

        this.loadStatus();
    },

    methods: {
        loadStatus() {
            this.$http.get(window.BASE_URL + '/status').then((response) => {
                let status = response.data;

                this.started = status.data.inProgress;
                this.databases = status.data.databases;
            });
        },

        startImport(event) {
            event.preventDefault();

            this.$http.post(window.BASE_URL + '/trigger').then((response) => {
                this.messages.push({
                    type: "start"
                });
                this.letters = response.data.data.letters;
                this.books = response.data.data.books;
                this.people = response.data.data.people;
                this.started = true;
            }).catch(() => {
                alert('Der Import konnte nicht gestartet werden!');
            });
        },

        onComplete() {
            this.loadStatus();
        },
    },

    computed: {
        letterProgress: function () {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'letters'
            );

            if (result.length > 0) {
                let item = result.slice(-1)[0];

                return item.amount + "/" + item.total || 0;
            }

            return 0;
        },
        personProgress: function () {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'people'
            );

            if (result.length > 0) {
                let item = result.slice(-1)[0];

                return item.amount + "/" + item.total || 0;
            }

            return 0;
        },
        bookProgress: function () {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'books'
            );

            if (result.length > 0) {
                let item = result.slice(-1)[0];

                return item.amount + "/" + item.total || 0;
            }

            return 0;
        }
    },

    components: {
        Upload
    }
});