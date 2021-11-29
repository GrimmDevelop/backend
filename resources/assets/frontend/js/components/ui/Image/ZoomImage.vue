<template>
    <div ref="container" class="relative w-full h-full" @wheel.prevent="scroll">
        <img class="absolute max-w-none" style="top: 0; left: 0;" ref="image" :src="src" alt="Handschrift">
        <div class="button-group absolute bottom-2 right-2 z-10 bg-gray-300 rounded p-3 cursor-pointer">
            <div class="zooming-buttons">
                <icon class="zooming mb-2" icon="zoom-in" @click="zoomIn"></icon>
<!--                <hr class="horizontal bg-gray-300"/>-->
                <icon class="zooming" icon="zoom-out" @click="zoomOut"></icon>
            </div>
            <hr class="horizontal-thick"/>
            <div class="rotating-button">
                <span class="rotating" @click="rotateImageRight">&#8635;</span>
<!--                <hr class="horizontal bg-gray-300"/>-->
                <span class="rotating" @click="rotateImageLeft">&#8634;</span>
            </div>

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
            };
        },

        props: {
            src: {},
            container: null,
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

            zoomIn(event) {
                // zoom
                const scroll = 50;

                const mouseX = this.containerWidth / 2;
                const mouseY = this.containerHeight / 2;

                const imageX = parseFloat(this.$refs.image.style.left);
                const imageY = parseFloat(this.$refs.image.style.top);

                const w = this.$refs.image.clientWidth;
                const h = this.$refs.image.clientHeight;

                const {x, y, newW, newH} = this.getTransformation(imageX, imageY, w, h, scroll, mouseX, mouseY);

                this.transformImage(x, y, newW, newH);
            },

            zoomOut(event) {
                // zoom
                const scroll = -50;

                const mouseX = this.containerWidth / 2;
                const mouseY = this.containerHeight / 2;

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
                // maybe there is more to do here in future
                this.centerImage();
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

.horizontal-thick{
    background-color: rgba(55, 65, 81, 1);
    border-radius: 8px;
    display: inline-block;
    width: 25px;
    height: 3px;
}

.rotating {
    font-size: x-large;
    display: block;
    height: 2rem;
    text-align: center;
}

.zooming {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>