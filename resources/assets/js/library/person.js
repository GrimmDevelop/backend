import '../bootstrap';

new Vue({
    el: '#app-container',

    data: {
        form:null
    },

    mounted() {
            this.form = this.$refs.personForm;
    }
});