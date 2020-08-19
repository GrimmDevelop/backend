<template>
    <nav class="navbar navbar-light bg-light border-top fixed-bottom">
        <div class="container justify-content-between">
            <div class="nav">
                <portal-target name="status-bar-left"></portal-target>
            </div>

            <div class="nav">
                <portal-target name="status-bar-right"></portal-target>

                <a class="ml-4 btn btn-info"
                   data-toggle="modal"
                   data-target="#help-modal">
                    <span class="fa fa-question-circle"></span>&nbsp;
                </a>

                <modal namespace="help" ref="helpModal">
                    <template slot="title">
                        Hilfe
                    </template>

                    <template slot="body">
                        Für diese Seite wurde noch keine Hilfe hinterlegt.
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Schließen
                        </button>
                    </template>
                </modal>
            </div>
        </div>
    </nav>
</template>

<script>
    import Modal from './Modal';

    export default {
        data() {
            return {
                //
            };
        },

        methods: {
            openHelpModal() {
                window.$(this.$refs.helpModal.$el).modal('show');
            }
        },

        components: {
            Modal
        }
    };
</script>
