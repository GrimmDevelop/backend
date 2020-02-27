<template>
    <div class="flex w-full h-screen">
        <div class="w-full h-full p-4 overflow-scroll">
            <zoom-image src="/media/raster.png"></zoom-image>
        </div>
        <div class="w-16 bg-blue-800 text-white py-4 flex flex-col items-center">
            right
            <icon icon="arrow-outline-up"></icon>
            <icon icon="add-outline"></icon>
            <icon icon="adjust"></icon>
            <icon icon="airplane"></icon>
            <icon icon="backspace"></icon>
        </div>
    </div>
</template>

<script>
    import ZoomImage from "./components/ui/Image/ZoomImage";

    export default {
        name: "App",

        components: {
            ZoomImage,
        },
    };
</script>
