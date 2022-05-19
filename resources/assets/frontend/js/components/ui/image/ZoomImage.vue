<template>
    <div class="h-full p-4 overflow-hidden" @wheel.prevent="scroll"
         @mousedown.prevent="mouseDown" @mouseup="mouseUP" @mousemove="move">
        <div class="relative h-full" ref="container">
            <img class="absolute max-w-none" style="top: 0; left: 0;" ref="image" :src="src" alt="Handschrift">
        </div>
        <div class="absolute bottom-4 right-4 z-10 bg-gray-200 grid-rows-5 rounded">
            <div class="zooming tooltip" @click="zoomIn">
                <span class="tooltiptext">Vergrößern</span>
                <icon icon="zoom-in"></icon>
            </div>
            <div class="zooming tooltip" @click="zoomOut">
                <span class="tooltiptext">Verkleinern</span>
                <icon icon="zoom-out"></icon>
            </div>
            <hr class="horizontal-thick"/>
            <div class="rotating tooltip" @click="rotateImageRight">
                <span class="tooltiptext">Drehen</span>
                <span>&#8635;</span>
            </div>
            <div class="rotating tooltip"  @click="rotateImageLeft">
                <span class="tooltiptext">Drehen</span>
                <span>&#8634;</span>
            </div>
            <hr class="horizonal-thick"/>
            <div class="zooming tooltip" @click="resetPosition"> <!-- same style as zoom, may need change later -->
                <span class="tooltiptext">Zurücksetzen</span>
                <icon icon="target"></icon>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ZoomImage",

        data() {
            return {
                imageLoaded: false,

                resolution: {
                    width: 0,
                    height: 0,
                },

                containerWidth: null,
                containerHeight: null,
                rotation: 0,

                targetFps: 30,
                duration: 300,
                moving: false,
                mouseOffsetX: 2,
                mouseOffsetY: 2,
            };
        },

        props: {
            src: {},
        },

        computed: {
            aspectRatio() {
                return this.resolution.width / this.resolution.height;
            }
        },

        mounted() {
            new ResizeObserver(() => {
                this.measureContainer();
                this.centerImage();
            }).observe(this.$refs.container);

            this.$refs.image.addEventListener('load', this.measureImage);
        },

        beforeDestroy() {
            this.$refs.image.removeEventListener('load', this.measureImage);
        },

        methods: {
            measureContainer() {
                this.containerWidth = this.$refs.container.clientWidth;
                this.containerHeight = this.$refs.container.clientHeight;
            },

            measureImage() {
                this.imageLoaded = true;
                this.resolution.width = this.$refs.image.naturalWidth;
                this.resolution.height = this.$refs.image.naturalHeight;

                this.centerImage();
            },

            getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY) {
                const newW = Math.max(w + scroll, 500);
                const scrolled = newW - w;

                const scale = (newW / w);

                const newH = h * scale;

                const newX = imageX - scrolled / 2;
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

            mouseDown(event) {
                this.mouseOffsetX = event.clientX - parseInt(this.$refs.image.style.left);
                this.mouseOffsetY = event.clientY - parseInt(this.$refs.image.style.top);
                this.moving = true;
            },

            mouseUP() {
                this.moving = false;
            },

            move(event) {
                if (this.moving) {
                    const x = event.clientX - this.mouseOffsetX;
                    const y = event.clientY - this.mouseOffsetY;

                    this.$refs.image.style.left = `${x}px`;
                    this.$refs.image.style.top = `${y}px`;
                }
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
                if (!this.imageLoaded) {
                    return;
                }

                const factor = 0.95;

                const imageWidth = this.containerWidth * factor;
                const imageHeight = imageWidth / this.aspectRatio;

                this.transformImage((this.containerWidth - imageWidth) / 2, this.containerHeight * (1 - factor) / 2, imageWidth, imageHeight);
            },

            transformImage(x, y, width, height) {
                x = Math.max(-width, Math.min(x, this.containerWidth));
                y = Math.max(-height, Math.min(y, this.containerHeight));

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
                this.rotation = 0;
                this.$refs.image.style.transform = `rotate(${this.rotation}deg)`;
                // maybe there is more to do here in future
                this.centerImage();
            }
        },
    };
</script>

<style scoped lang="scss">
    @import "resources/assets/frontend/sass/_variables.scss";

    .horizontal-thick {
        background-color: rgba(55, 65, 81, 1);
        width: 100%;
    }

    .rotating {
        font-size: x-large;
        display: block;
        line-height: 1.2rem;
        text-align: center;
        cursor: pointer;
        user-select: none;
        padding-top: 12px;
        padding-bottom: 16px;
        border-radius: 5px;
    }

    .zooming {
        display: block;
        margin-left: auto;
        margin-right: auto;
        cursor: pointer;
        user-select: none;
        padding: 12px;
        padding-bottom: 8px;
        border-radius: 5px;
    }

    .rotating:hover, .zooming:hover{
        background: $gray-300;
    }

    .tooltip{
    position: relative;
    }
    .tooltip .tooltiptext {
        font-size: medium;
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text */
        position: absolute;
        z-index: 1;
        top: +5px;
        right: 105%;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

</style>