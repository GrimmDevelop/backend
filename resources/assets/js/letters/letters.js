import '../bootstrap';

new Vue({
    el: '#letters',

    methods: {
        showLimitWarning(exportLimitExceeded) {
            if (exportLimitExceeded) {
                alert('Sie versuchen mehr als 5000 Datensätze zu exportieren. Die Anzahl ist auf 5000 begrenzt.');
            }
        }
    }
});