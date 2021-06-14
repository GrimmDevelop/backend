<template>
    <div class="column-Box">
        <div class="text-box">
            <letter-text :text="letter.text"/>
        </div>
    </div>
</template>

<script>
    import LetterText from "@/frontend/js/modules/Letters/LetterText";

    export default {
        name: "TextWindow",

        props: {
            letter: {},
        },

        components: {
            LetterText
        },
    };
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