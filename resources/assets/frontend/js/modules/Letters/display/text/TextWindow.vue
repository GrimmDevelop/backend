<template>
    <div class="column-Box">
        <div class="text-box">
            <p v-html="letter.text"></p>
        </div>
    </div>
</template>

<script>
export default {
    name: "TextWindow",


    props: {
        letter: {},
    },
}
</script>

<style scoped>
.text-box {
    height: 95vh;
    margin: 0.1rem;
    overflow-x: auto;
}

.column-Box {
    display: grid;
    grid-template-columns: 1fr;
    padding: 0.1rem;
}

</style>