<template>
    <div ref="container" class="relative w-full h-full overflow-hidden" @wheel.prevent="scroll">
        <img class="absolute max-w-none" style="top: 0; left: 0;" ref="image" :src="src" alt="Handschrift">

        <div class="absolute bottom-4 right-4 z-10 bg-gray-200 rounded flex flex-col gap-3 p-3">
            <icon class="zooming" icon="zoom-in" style="color: #495057" @click="zoomIn"></icon>
            <icon class="zooming" icon="zoom-out" style="color: #495057" @click="zoomOut"></icon>
            <hr class="horizontal-thick"/>
            <span class="rotating text-gray-700" @click="rotateImageRight">&#8635;</span>
            <span class="rotating text-gray-700" @click="rotateImageLeft">&#8634;</span>
            <hr class="horizontal-thick"/>
            <icon class="reset" icon="target" style="color: #495057" @click="resetPosition"></icon>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ZoomImage",

        data() {
            return {
                containerWidth: null,
                containerHeight: null,
                rotation: 0,

                targetFps: 30,
                duration: 300,
            };
        },

        props: {
            src: {},
        },

        mounted() {
            new ResizeObserver(() => {
                this.measureContainer();
                this.centerImage();
            }).observe(this.$refs.container);
        },

        methods: {
            measureContainer() {
                this.containerWidth = this.$refs.container.clientWidth;
                this.containerHeight = this.$refs.container.clientHeight;
            },

            getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY) {
                const newW = Math.max(w + scroll, 500);
                const scale = (newW / w);

                const newH = h * scale;

                const newX = imageX - scroll / 2;
                const newY = imageY - (newH - h) / 2;

                const centerX = imageX + w / 2;
                const centerY = imageY + h / 2;

                const scaledX = centerX - (centerX - mouseX) * scale;
                const scaledY = centerY - (centerY - mouseY) * scale;

                const offsetX = scaledX - mouseX;
                const offsetY = scaledY - mouseY;

                const x = newX - offsetX;
                const y = newY - offsetY;

                return {x, y, newW, newH};
            },

            scroll(event) {
                this.measureContainer();

                /** @var {WheelEvent} event */
                if (event.ctrlKey) {
                    // zoom
                    const scroll = -this.deltaY(event);

                    const mouseX = event.clientX - this.$refs.container.offsetLeft;
                    const mouseY = event.clientY - this.$refs.container.offsetTop;

                    this.zoomTo(scroll, {
                        x: mouseX,
                        y: mouseY,
                    });
                } else {
                    // scroll
                    this.transformImage(
                        parseFloat(this.$refs.image.style.left) - event.deltaX,
                        parseFloat(this.$refs.image.style.top) - event.deltaY,
                        this.$refs.image.clientWidth,
                        this.$refs.image.clientHeight
                    );
                }
            },

            zoomIn() {
                this.zoom(150);
            },

            zoomOut() {
                this.zoom(-150);
            },

            zoom(target) {
                const targetFps = this.targetFps;
                const duration = this.duration;

                const frameTime = duration / targetFps;

                let current = 0;
                let step = 0;

                const interval = setInterval(() => {
                    if (step > duration + 0.00005) {
                        clearInterval(interval);
                        return;
                    }

                    current = target / targetFps * 2 * this.bezier(step / duration);

                    this.zoomTo(current, {
                        x: this.containerWidth / 2,
                        y: this.containerHeight / 2,
                    });

                    step += frameTime;
                }, frameTime);
            },

            bezier(k) {
                k = Math.min(1, Math.max(0, k));

                const p = 1.67;

                if (k < 0.5) {
                    return Math.pow(k * 2, p) * 0.5;
                } else {
                    return (1 - Math.pow(1 - (k - 0.5) * 2, p)) * 0.5 + 0.5;
                }
            },

            zoomTo(scroll, pointOfReference = null) {
                const mouseX = pointOfReference.x;
                const mouseY = pointOfReference.y;

                const imageX = parseFloat(this.$refs.image.style.left);
                const imageY = parseFloat(this.$refs.image.style.top);

                const w = this.$refs.image.clientWidth;
                const h = this.$refs.image.clientHeight;

                const {x, y, newW, newH} = this.getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY);

                this.transformImage(x, y, newW, newH);
            },

            centerImage() {
                const factor = 0.9;

                const imageWidth = this.containerWidth * factor;

                // TODO: calculate image height based on width

                this.transformImage((this.containerWidth - imageWidth) / 2, 100, imageWidth);
            },


            centerImageNew() {
                const factor = 0.9;

                const imageHeight = this.containerWidth * factor;

                // TODO: calculate image height based on width

                this.transformImage(100, (this.containerWidth - imageHeight) / 2, 1000 , imageHeight);
                this.centerImage();
            },

            transformImage(x, y, width, height) {
                x = Math.max(-width + 100, Math.min(x, this.containerWidth - 100));
                y = Math.max(-height + 500, Math.min(y, this.containerHeight - 100));

                this.$refs.image.style.left = `${x}px`;
                this.$refs.image.style.top = `${y}px`;
                this.$refs.image.style.width = `${width}px`;
            },

            deltaY(event) {
                let factor = 7.5;
                if (event.shiftKey) {
                    factor = 0.8;
                }

                return event.deltaY * factor;
            },

            rotateImageRight() {
                this.rotation = (this.rotation + 90) % 360;
                this.$refs.image.style.transform = `rotate(${this.rotation}deg)`;
            },

            rotateImageLeft() {
                this.rotation = (this.rotation - 90) % 360;
                this.$refs.image.style.transform = `rotate(${this.rotation}deg)`;
            },

            resetPosition() {
                // maybe there is more to do here in future
                this.centerImageNew();
            }
        },
    };
</script>

<style scoped lang="scss">
    @import "~@/sass/variables";

    //.zooming-buttons{
    //    display: block;
    //}
    //
    //.rotating-button{
    //    display: block;
    //}
    //
    //.button-group{
    //    display: block;
    //}

    //.horizontal{
    //    background-color: rgba(55, 65, 81, 1);
    //    border-radius: 8px;
    //    display: inline-block;
    //    width: 20px;
    //    //margin: auto;
    //}

    .horizontal-thick {
        background-color: rgba(55, 65, 81, 1);
        border-radius: 8px;
        display: inline-block;
        width: 100%;
        height: 3px;
        color: #495057;
    }

    .rotating {
        font-size: x-large;
        display: block;
        line-height: 1.2rem;
        text-align: center;
        cursor: pointer;
        user-select: none;
    }

    .zooming {
        display: block;
        margin-left: auto;
        margin-right: auto;
        cursor: pointer;
        user-select: none;
    }
</style>