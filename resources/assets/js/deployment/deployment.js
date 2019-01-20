import '../bootstrap';

import Pusher from 'pusher-js';

new window.Vue({
    el: '#app-container',

    data: {
        messages: [],
        started: false,
        done: false,
        books: 0,
        people: 0,
        libraryBooks: 0,
        last: null,
        blank: false,
        blankStarted: false,
        history: []
    },

    mounted() {
        this.pusher = new Pusher(window.PUSHER_KEY, {
            cluster: window.PUSHER_CLUSTER
        });

        let channel = 'user.' + window.USER_ID;
        this.pusherChannel = this.pusher.subscribe(channel);

        this.pusherChannel.bind('App\\Events\\DeployProgress', (message) => {
            this.messages.push({
                type: "update",
                entity: message.type,
                amount: message.amount
            });
        });

        this.pusherChannel.bind('App\\Events\\DeploymentDone', () => {
            this.done = true;
            this.started = false;
        });

        window.axios.get(window.BASE_URL + '/status').then((response) => {
            let status = response.data;

            this.started = status.data.inProgress;
            this.last = new Date(status.data.last);
            this.blank = status.data.blank;
            if (!this.blank) {
                window.axios.get(window.HISTORY_URL, {params: {date: this.last.toISOString()}}).then((response) => {
                    this.history = response.data.data.history;
                });
            }
        });
    },

    methods: {
        deploy(event) {
            event.preventDefault();
            window.axios.post(window.BASE_URL + '/trigger').then((response) => {
                this.messages.push({
                    type: "start"
                });
                this.books = response.data.data.books;
                this.people = response.data.data.people;
                this.libraryBooks = response.data.data.libraryBooks;
                this.started = true;
            }).catch(() => {
                alert('Die Veröffentlichung konnte nicht gestartet werden!');
            });
        },

        blankify(event) {
            event.preventDefault();
            this.blankStarted = true;
            window.$.post(window.BASE_URL + '/blankify').done(() => {
                alert('Der Index wurde geleert!');
                this.blankStarted = false;
            }).fail(() => {
                alert('Der Index konnte nicht geleert werden');
                this.blankStarted = false;
            });
        }
    },

    computed: {
        personProgress() {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'Grimm\\Person'
            );

            if (result.length > 0) {
                return result.slice(-1)[0].amount || 0;
            }

            return 0;
        },
        bookProgress() {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'Grimm\\Book'
            );

            if (result.length > 0) {
                return result.slice(-1)[0].amount || 0;
            }

            return 0;
        },
        libraryBookProgress() {
            let result = this.messages.filter((val) =>
                val.type === 'update' && val.entity === 'Grimm\\LibraryBook'
            );

            if (result.length > 0) {
                return result.slice(-1)[0].amount || 0;
            }

            return 0;
        }
    }
});
