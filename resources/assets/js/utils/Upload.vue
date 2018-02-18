<template>
    <div>
        <slot name="header">Datei auswählen</slot>

        <p class="btn-group">
            <button type="button" class="btn btn-default"
                    v-on:click="flowOpenFileDialog()">
                <span class="glyphicon glyphicon-upload"></span>
            </button>

            <button type="button" class="btn btn-primary" v-show="fileSelected"
                    v-on:click="flowStartUpload()"
                    :disabled="uploadCompleted">
                <span class="glyphicon glyphicon-ok"></span>
            </button>
        </p>

        <input ref="flowFileInput" type="file" style="visibility: hidden; position: absolute;">

        <div class="progress" v-if="uploadRunning">
            <div ref="flowProgress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                 aria-valuemax="100"
                 style="width: 0; min-width: 2em;">
                0%
            </div>
        </div>

        <slot name="footer"></slot>
    </div>
</template>

<script>
    import Flow from '@flowjs/flow.js';

    export default {
        props: ['target'],

        data() {
            return {
                flow: null,
                fileSelected: false,
                uploadRunning: false,
                uploadCompleted: false
            }
        },

        mounted() {
            this.flowInitialize();

            this.flowBindEvents();
        },

        methods: {
            flowInitialize() {
                this.flow = new Flow({
                    target: this.target,
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    },
                    query: {}
                });

                this.flow.assignBrowse(this.$refs.flowFileInput, false, false, {});
            },

            flowBindEvents() {
                this.flow.on('fileAdded', (file, event) => {
                    this.fileSelected = true;
                });

                this.flow.on('fileProgress', (file, event) => {
                    this.uploadRunning = true;

                    let progress = Math.round(file.progress() * 10000) / 100;

                    let bar = $(this.$refs.flowProgress);

                    bar.text(progress + "%");
                    bar.css('width', progress + "%");
                });

                this.flow.on('fileSuccess', (file, message) => {
                    this.uploadCompleted = true;

                    $(this.$refs.flowProgress).addClass('progress-bar-success');

                    setTimeout(() => {
                        this.flowReset();
                    }, 2500);
                });

                this.flow.on('fileError', (file, message) => {
                    this.uploadCompleted = false;
                    $(this.$refs.flowProgress).addClass('progress-bar-danger');
                });
            },

            flowOpenFileDialog() {
                $(this.$refs.flowFileInput).click();
            },

            flowStartUpload() {
                this.flow.upload();
            },

            flowReset() {
                this.fileSelected = false;
                this.uploadRunning = false;
                this.uploadCompleted = false;

                this.flow.cancel();
            }
        }
    }
</script>