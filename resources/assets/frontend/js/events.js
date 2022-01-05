import store from './store';

/**
 * @property channel {Channel}
 */
class Events {
    constructor() {
        this.channel = window.Echo.private('events/' + store.getters.user);
    }

    emit(event, data = null) {
        this.channel.whisper(event, data);
    }

    on(event, callback) {
        this.channel.listenForWhisper(event, callback);
    }
}

const events = new Events();

export default events;