import '../bootstrap';

new window.Vue({
    el: '#app-container',

    data: {
        form:null
    },

    mounted() {
            this.form = this.$refs.personForm;
    }
});