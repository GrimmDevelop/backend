<template>
    <div v-if="letter">
        <scan-column :letter="letter"></scan-column>
    </div>
</template>

<script>
    import ScanColumn from "@/frontend/js/modules/Letters/display/scans/ScanColumn";

    export default {
        name: "Scan",

        data() {
            return {
                letter: null,
            };
        },

        computed: {
            id() {
                return this.$route.params.id;
            },
        },

        watch: {
            id: {
                immediate: true,
                handler() {
                    this.$http.get(`/data/letters/${this.id}`)
                        .then(response => this.letter = response.data.data);
                },
            },
        },

        components: {
            ScanColumn
        },
    };
</script>

<style scoped>

</style>