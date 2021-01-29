export default class Bus {
    constructor() {
        this.busId = 1;
        this.eventBus = window.Echo.join('window.' + this.busId);
        this.callback = null;
    }

    open(href) {
        this.targetWindow = window.open(href);
    }

    send(message) {
        const encodedMessage = JSON.stringify(message);

        this.targetWindow.postMessage(encodedMessage, location.origin);
    }
}