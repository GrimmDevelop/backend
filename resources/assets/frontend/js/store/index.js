import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        token: null,
        splitVisibility: {
            scan: true,
            text: true,
        },
        open: {
            scan: false,
            text: false,
        },
    },
    getters: {
        getVisibilityScan: state => {
            return state.splitVisibility.scan;
        },
        getVisibilityText: state => {
            return state.splitVisibility.text;
        },
        getVisibilityMeta: state => {
            return state.splitVisibility.meta;
        },
    },
    mutations: {
        set_user(state, token) {
            state.token = token;
        },

        changeScanVisibility(state) {
            state.splitVisibility.scan = !state.splitVisibility.scan;
        },
        changeTextVisibility(state) {
            state.splitVisibility.text = !state.splitVisibility.text;
        },
        changeScanOpen(state) {
            state.open.scan = !state.open.scan;
        },
        changeTextOpen(state) {
            state.open.text = !state.open.text;
        },
    },
    actions: {
        changeVisibility({commit, state}, type) {
            if (type.payload === 'scan') {
                commit({
                    type: "changeScanVisibility"
                });
            } else if (type.payload === 'text') {
                commit({
                    type: "changeTextVisibility"
                });
            } else {
                console.log(`An error occurred in method changeVisibility with the type of ${type}`);
                return 1;
            }
        },
        changeOpen({commit, state}, type) {
            if (type.payload === 'scan') {
                commit({
                    type: "changeScanOpen"
                });
            } else if (type.payload === 'text') {
                commit({
                    type: "changeTextOpen"
                });
            } else {
                console.log(`An error occurred in method changeOpen with the type of ${type}`);
                return 1;
            }
        }
    }
});