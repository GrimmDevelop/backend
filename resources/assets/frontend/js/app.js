import Vue from 'vue';


import LetterEditor from "../../../views/letters/LetterEditor";

// Vue.component('LetterEditor', LetterEditor);

new Vue({
    el: '#app',
    component: {
        LetterEditor,
    },
    template: '<div><span>LetterEditor:: !! </span> <letter-editor></letter-editor> </div>'

});
