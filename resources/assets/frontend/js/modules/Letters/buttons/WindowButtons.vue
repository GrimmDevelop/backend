<template>
    <div class="absolute top-4 right-4 z-10">
        <div class="flex items-center">
            <button type="button" class="flex bg-gray-300 bg-opacity-75 hover:bg-opacity-100 block px-3 py-2 rounded-l"
                    @click="$emit('popout')">
                <icon icon="share"></icon>
            </button>
            <button class="flex bg-gray-300 bg-opacity-75 hover:bg-opacity-100 block px-3 py-2 rounded-r" type="button"
                    @click="$emit('close')">
                <icon icon="close"></icon>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WindowButtons",
    };
</script>