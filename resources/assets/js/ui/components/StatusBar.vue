<template>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="nav navbar-form navbar-left">
                <portal-target name="status-bar-left"></portal-target>
            </div>

            <div class="nav navbar-form navbar-right">
                <a class="btn btn-info"
                   data-toggle="modal"
                   data-target="#help-modal"
                >
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Schließen
                        </button>
                    </template>
                </modal>
            </div>

            <div class="nav navbar-form navbar-right">
                <portal-target name="status-bar-right"></portal-target>
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
