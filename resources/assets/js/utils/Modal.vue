<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <portal-target :name="namespace + '-modal-title'"></portal-target>
                    </h4>
                </div>
                <div class="modal-body">
                    <portal-target :name="namespace + '-modal-body'"></portal-target>
                </div>
                <div class="modal-footer">
                    <portal-target :name="namespace + '-modal-footer'">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </portal-target>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['namespace'],
    }
</script>
