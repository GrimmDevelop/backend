<template>
    <div class="split-buttons-area">
        <div class="split-buttons">
            <button type="button" @click="$emit('popout')">
                <icon icon="share"></icon>
            </button><!--
            --><button class="close-button" type="button" @click="$emit('close')">
                &times;
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "WindowButtons"
}
</script>

<style scoped>

.close-button {
    font-size: 1.8rem;
}
.split-buttons-area {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
    padding: 0.9rem 1.2rem 0 0;
}
.split-buttons{
    /*border-radius: 5px;*/
    /*color: #2c5282; // blue*/
    border-radius: 8px;
    padding: 0 0.3rem 0.1rem 0.3rem;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
}

</style>