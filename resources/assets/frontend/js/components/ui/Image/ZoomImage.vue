<template>
    <div ref="container" class="relative w-full h-full" @wheel.prevent="scroll">
        <img class="absolute max-w-none" style="top: 0; left: 0;" ref="image" :src="src" alt="Brief">
    </div>
</template>

<script>
    export default {
        name: "ZoomImage",

        data() {
            return {
                containerWidth: null,
                containerHeight: null,
            };
        },

        props: {
            src: {},
        },

        mounted() {
            this.measureContainer();

            this.centerImage();
        },

        methods: {
            measureContainer() {
                this.containerWidth = this.$refs.container.clientWidth;
                this.containerHeight = this.$refs.container.clientHeight;
            },

            getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY) {
                const newW = Math.max(w + scroll, 10);
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

                    const imageX = parseFloat(this.$refs.image.style.left);
                    const imageY = parseFloat(this.$refs.image.style.top);

                    const w = this.$refs.image.clientWidth;
                    const h = this.$refs.image.clientHeight;

                    const {x, y, newW, newH} = this.getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY);

                    this.transformImage(x, y, newW, newH);
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

            centerImage() {
                this.transformImage(this.containerWidth / 4, 0, this.containerWidth / 2);
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
        },
    };
</script>
