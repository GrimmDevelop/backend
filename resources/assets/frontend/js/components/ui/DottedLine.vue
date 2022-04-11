<template>
    <div class="dotted-line">
        <br>
    </div>
</template>

<script>
    export default {
        name: "DottedLine"
    };
</script>

<style scoped>

    .dotted-line {
        /* creation of a line https://jsfiddle.net/yyp67pbg/ */
        background-image: linear-gradient(to right, gray 30%, rgba(255, 255, 255, 0) 0%);
        /*vertical position*/
        background-position: center;
        /* first value: how long the dashed lines are/ second value: how big the dashed lines are*/
        background-size: 20px 1px;
        /* repeat it in horizontal direction */
        background-repeat: repeat-x;
        /*centering*/
        width: 95%;
        margin: 2.5rem auto;
    }
</style>
