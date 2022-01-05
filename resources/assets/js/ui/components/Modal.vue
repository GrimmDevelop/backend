<template>
    <portal to="modal-container">
        <div :id="id" :ref="ref" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <portal-target :name="namespace + '-modal-title'">
                                <slot name="title"></slot>
                            </portal-target>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <portal-target :name="namespace + '-modal-body'">
                            <slot name="body"></slot>
                        </portal-target>
                    </div>
                    <div class="modal-footer">
                        <portal-target :name="namespace + '-modal-footer'">
                            <slot name="footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </slot>
                        </portal-target>
                    </div>
                </div>
            </div>
        </div>
    </portal>
</template>

<script>
    export default {
        props: ['namespace'],

        computed: {
            id() {
                return `${this.namespace}-modal`;
            },

            ref() {
                return `${this.namespace}Modal`;
            },
        },

        mounted() {
            this.$nextTick(() => {
                window.$(this.$refs[this.ref]).on('shown.bs.modal', () => {
                    this.$emit("shown");
                });
            });
        }
    };
</script>
