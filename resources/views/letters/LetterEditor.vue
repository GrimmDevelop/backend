<template>
    <div>
       <span> Hallo Welt! </span>
        <input class="name-input" v-model="name">
        <p> Name is: {{ name }} </p>
        {{ letter }}
    </div>
</template>

<script>
export default {
name: "LetterEditor",
    data() {
        return {
            letter: null,
            name: "Tom"
        }
    },
    // watch: {
    //     id: {
    //         immediate: true,
    //         handler() {
    //             this.$http.get(`data/letters/${this.id}`)
    //                 .then((response) => this.letter = response.data.data);
    //         }
    //     }
    // },
}
</script>

<style scoped>
.name-input {
    border: 1px solid black;
    border-radius: 5px;
    color: blue;
    background: gray;
}

</style>